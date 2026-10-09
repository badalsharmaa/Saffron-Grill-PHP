/**
 * Calcutta Chaat & Bakery — Universal WordPress-Style Media Picker Modal
 * Usage:
 * CMSMediaPicker.open({
 *     title: 'Select Dish Image',
 *     onSelect: function(item) {
 *         // item: { id, file_path, thumb_path, title, alt_text, width, height }
 *     }
 * });
 */

window.CMSMediaPicker = (function () {
    'use strict';

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    let modalEl = null;
    let activeCallback = null;
    let selectedItem = null;
    let mediaItems = [];
    let currentTab = 'library'; // 'library' | 'upload'
    let currentSearch = '';

    function ensureModal() {
        if (modalEl) return;

        modalEl = document.createElement('div');
        modalEl.id = 'cmsMediaPickerModal';
        modalEl.className = 'modal-backdrop';
        modalEl.style.cssText = 'display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(4px);';

        modalEl.innerHTML = `
            <div class="media-picker-dialog" style="background: #FFFFFF; width: 92%; max-width: 960px; height: 85vh; border-radius: var(--radius-lg, 16px); display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Modal Top Header -->
                <div class="media-picker-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color, #E2E8F0); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="display: flex; color: #0284C7;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </span>
                        <h3 id="mediaPickerTitle" style="font-size: 17px; font-weight: 700; color: var(--navy, #0F172A); margin: 0;">Select Media</h3>
                    </div>
                    <button type="button" id="closePickerBtn" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--text-muted, #94A3B8); padding: 0 4px; line-height: 1;">&times;</button>
                </div>

                <!-- Tabs & Search Bar (WordPress Media Tabs) -->
                <div class="media-picker-nav" style="padding: 0.75rem 1.5rem; background: var(--bg-subtle, #F1F5F9); border-bottom: 1px solid var(--border-color, #E2E8F0); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div class="picker-tabs" style="display: flex; gap: 8px;">
                        <button type="button" class="btn btn-sm picker-tab active" id="tabLibraryBtn" style="font-size: 12px; font-weight: 600;">Media Library</button>
                        <button type="button" class="btn btn-sm btn-secondary picker-tab" id="tabUploadBtn" style="font-size: 12px; font-weight: 600;">Upload Files</button>
                    </div>
                    <div class="picker-search-box" id="pickerSearchBox" style="position: relative;">
                        <input type="text" id="pickerSearchInput" class="form-control form-control-sm" placeholder="Search photos..." style="width: 200px; font-size: 12px; padding-left: 28px;">
                        <span style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: var(--text-muted, #94A3B8); pointer-events: none;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                    </div>
                </div>

                <!-- Body Pane -->
                <div class="media-picker-body" style="flex: 1; display: flex; overflow: hidden; position: relative;">
                    <!-- TAB 1: MEDIA LIBRARY (Grid on left, info inspector on right) -->
                    <div id="paneLibrary" style="flex: 1; display: flex; overflow: hidden; width: 100%;">
                        <div id="pickerGrid" style="flex: 1; overflow-y: auto; padding: 1.25rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(115px, 1fr)); gap: 10px; align-content: flex-start;">
                            <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted, #94A3B8); padding: 3rem;">Loading media library...</div>
                        </div>

                        <!-- Sidebar Attachment Details Drawer -->
                        <div id="pickerSidebar" style="width: 260px; border-left: 1px solid var(--border-color, #E2E8F0); background: #FAFBFD; padding: 1rem; overflow-y: auto; display: none; font-size: 12px;">
                            <div style="font-weight: 700; color: var(--navy, #0F172A); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.04em; font-size: 11px;">Attachment Details</div>
                            <div style="text-align: center; margin-bottom: 12px;">
                                <img id="pickerSideThumb" src="" alt="" style="max-width: 100%; max-height: 140px; border-radius: 8px; object-fit: contain; border: 1px solid var(--border-color, #E2E8F0); background: #fff;">
                            </div>
                            <div style="margin-bottom: 6px; font-weight: 600; color: var(--navy, #0F172A); word-break: break-all;" id="pickerSideFilename">-</div>
                            <div style="font-size: 11px; color: var(--text-muted, #94A3B8); margin-bottom: 12px;" id="pickerSideMeta">-</div>
                            
                            <div class="form-group" style="margin-bottom: 8px;">
                                <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary, #475569); display: block; margin-bottom: 2px;">Alt Text</label>
                                <input type="text" id="pickerSideAlt" class="form-control form-control-sm" style="font-size: 11.5px;" placeholder="Image description">
                            </div>

                            <div class="form-group" style="margin-bottom: 8px;">
                                <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary, #475569); display: block; margin-bottom: 2px;">Title</label>
                                <input type="text" id="pickerSideTitle" class="form-control form-control-sm" style="font-size: 11.5px;" placeholder="Display title">
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: UPLOAD DROPZONE -->
                    <div id="paneUpload" style="flex: 1; display: none; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; text-align: center; width: 100%;">
                        <div class="picker-upload-dropzone" id="pickerDropArea" style="border: 2px dashed #CBD5E1; border-radius: 16px; padding: 3rem 2rem; max-width: 460px; width: 100%; cursor: pointer; transition: all 0.2s ease; background: #FAFBFD;">
                            <input type="file" id="pickerFileInput" multiple accept="image/*,application/pdf" style="display: none;">
                            <div style="font-size: 44px; margin-bottom: 10px;">☁️</div>
                            <div style="font-size: 16px; font-weight: 700; color: var(--navy, #0F172A); margin-bottom: 4px;">Drop files to upload</div>
                            <div style="font-size: 12.5px; color: var(--text-muted, #94A3B8); margin-bottom: 16px;">or browse files from your computer</div>
                            <button type="button" class="btn btn-primary btn-sm" style="pointer-events: none;">Select Files</button>
                        </div>
                        <div id="pickerUploadProgress" style="display: none; margin-top: 1rem; width: 100%; max-width: 460px;">
                            <div style="font-size: 12px; color: var(--navy, #0F172A); font-weight: 600; margin-bottom: 4px;" id="pickerUploadStatus">Uploading...</div>
                            <div class="upload-progress-track" style="height: 6px; background: #E2E8F0; border-radius: 9999px; overflow: hidden;">
                                <div id="pickerProgressBar" style="width: 0%; height: 100%; background: #0284C7; transition: width 0.2s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Bottom Action Bar -->
                <div class="media-picker-footer" style="padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-color, #E2E8F0); display: flex; justify-content: space-between; align-items: center; background: #FFFFFF;">
                    <div style="font-size: 12px; color: var(--text-muted, #94A3B8);" id="pickerSelectedNotice">
                        No image selected
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn btn-secondary btn-sm" id="pickerCancelBtn">Cancel</button>
                        <button type="button" class="btn btn-primary btn-sm" id="pickerSelectBtn" disabled>Use This Media</button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modalEl);

        // Attach event listeners
        bindEvents();
    }

    function bindEvents() {
        const closeBtn = modalEl.querySelector('#closePickerBtn');
        const cancelBtn = modalEl.querySelector('#pickerCancelBtn');
        const selectBtn = modalEl.querySelector('#pickerSelectBtn');

        const tabLib = modalEl.querySelector('#tabLibraryBtn');
        const tabUp = modalEl.querySelector('#tabUploadBtn');
        const paneLib = modalEl.querySelector('#paneLibrary');
        const paneUp = modalEl.querySelector('#paneUpload');
        const searchBox = modalEl.querySelector('#pickerSearchBox');
        const searchInput = modalEl.querySelector('#pickerSearchInput');

        const dropArea = modalEl.querySelector('#pickerDropArea');
        const fileInput = modalEl.querySelector('#pickerFileInput');

        closeBtn.addEventListener('click', close);
        cancelBtn.addEventListener('click', close);
        modalEl.addEventListener('click', (e) => {
            if (e.target === modalEl) close();
        });

        // Tab Switching
        tabLib.addEventListener('click', () => {
            currentTab = 'library';
            tabLib.classList.add('active');
            tabLib.classList.remove('btn-secondary');
            tabUp.classList.remove('active');
            tabUp.classList.add('btn-secondary');
            paneLib.style.display = 'flex';
            paneUp.style.display = 'none';
            searchBox.style.display = 'block';
        });

        tabUp.addEventListener('click', () => {
            currentTab = 'upload';
            tabUp.classList.add('active');
            tabUp.classList.remove('btn-secondary');
            tabLib.classList.remove('active');
            tabLib.classList.add('btn-secondary');
            paneLib.style.display = 'none';
            paneUp.style.display = 'flex';
            searchBox.style.display = 'none';
        });

        // Search Input
        let debounce = null;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                currentSearch = e.target.value.trim();
                fetchPickerItems();
            }, 300);
        });

        // Upload Area
        dropArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files.length > 0) {
                uploadPickerFiles(Array.from(fileInput.files));
                fileInput.value = '';
            }
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.style.borderColor = '#0284C7';
            dropArea.style.background = '#F0F9FF';
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.style.borderColor = '#CBD5E1';
            dropArea.style.background = '#FAFBFD';
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.style.borderColor = '#CBD5E1';
            dropArea.style.background = '#FAFBFD';
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                uploadPickerFiles(Array.from(e.dataTransfer.files));
            }
        });

        // Select Button
        selectBtn.addEventListener('click', () => {
            if (selectedItem && activeCallback) {
                // If user edited alt or title in sidebar, persist it
                const altInput = modalEl.querySelector('#pickerSideAlt');
                const titleInput = modalEl.querySelector('#pickerSideTitle');
                if (altInput && titleInput) {
                    selectedItem.alt_text = altInput.value.trim();
                    selectedItem.title = titleInput.value.trim();
                }

                activeCallback(selectedItem);
            }
            close();
        });
    }

    function fetchPickerItems(preselectId) {
        const grid = modalEl.querySelector('#pickerGrid');
        grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 3rem;">Loading images...</div>';

        const params = new URLSearchParams({
            action: 'ajax_media_list',
            limit: 60,
            s: currentSearch,
            mime: 'image'
        });

        fetch('/admin.php?' + params.toString())
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--danger); padding: 2rem;">Failed to load media.</div>';
                    return;
                }

                mediaItems = data.data.items || [];
                renderGrid(preselectId);
            })
            .catch(() => {
                grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--danger); padding: 2rem;">Network error loading media.</div>';
            });
    }

    function renderGrid(preselectId) {
        const grid = modalEl.querySelector('#pickerGrid');
        grid.innerHTML = '';

        if (mediaItems.length === 0) {
            grid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 3rem;">No media items found.</div>';
            return;
        }

        mediaItems.forEach(item => {
            const tile = document.createElement('div');
            tile.className = 'picker-grid-tile';
            tile.style.cssText = 'position: relative; aspect-ratio: 1; border: 2px solid transparent; border-radius: 8px; overflow: hidden; cursor: pointer; background: #F1F5F9; transition: all 0.15s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.05);';
            tile.setAttribute('data-id', item.id);

            const isSelected = selectedItem && (selectedItem.id === item.id || preselectId === item.id);
            if (isSelected) {
                tile.style.borderColor = '#0284C7';
                tile.style.boxShadow = '0 0 0 2px #0284C7';
            }

            tile.innerHTML = `
                <img src="${item.thumb_path || item.file_path}" alt="${item.alt_text || item.title}" style="width: 100%; height: 100%; object-fit: cover; display: block;" onerror="this.src='/favicon.ico'">
                <div class="picker-tile-check" style="display: ${isSelected ? 'flex' : 'none'}; position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: #0284C7; color: #fff; border-radius: 4px; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            `;

            tile.addEventListener('click', () => {
                selectItem(item, tile);
            });

            grid.appendChild(tile);

            if (isSelected) {
                selectItem(item, tile);
            }
        });
    }

    function selectItem(item, tileEl) {
        selectedItem = item;

        // Reset tiles highlight
        modalEl.querySelectorAll('.picker-grid-tile').forEach(t => {
            t.style.borderColor = 'transparent';
            t.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';
            const chk = t.querySelector('.picker-tile-check');
            if (chk) chk.style.display = 'none';
        });

        if (tileEl) {
            tileEl.style.borderColor = '#0284C7';
            tileEl.style.boxShadow = '0 0 0 2px #0284C7';
            const chk = tileEl.querySelector('.picker-tile-check');
            if (chk) chk.style.display = 'flex';
        }

        // Update Bottom Bar
        const notice = modalEl.querySelector('#pickerSelectedNotice');
        const selectBtn = modalEl.querySelector('#pickerSelectBtn');
        notice.innerHTML = `Selected: <strong>${escapeHtml(item.filename)}</strong> (${item.formatted_size})`;
        selectBtn.disabled = false;

        // Update Sidebar Inspector
        const sidebar = modalEl.querySelector('#pickerSidebar');
        sidebar.style.display = 'block';

        modalEl.querySelector('#pickerSideThumb').src = item.file_path;
        modalEl.querySelector('#pickerSideFilename').textContent = item.filename;
        modalEl.querySelector('#pickerSideMeta').textContent = `${item.width || '—'} × ${item.height || '—'} • ${item.formatted_size}`;
        modalEl.querySelector('#pickerSideAlt').value = item.alt_text || '';
        modalEl.querySelector('#pickerSideTitle').value = item.title || '';
    }

    function uploadPickerFiles(files) {
        if (!files || files.length === 0) return;

        const progressContainer = modalEl.querySelector('#pickerUploadProgress');
        const progressBar = modalEl.querySelector('#pickerProgressBar');
        const statusLabel = modalEl.querySelector('#pickerUploadStatus');

        progressContainer.style.display = 'block';
        statusLabel.textContent = `Uploading ${files.length} file(s)...`;
        progressBar.style.width = '20%';

        const file = files[0]; // Upload first
        const formData = new FormData();
        formData.append('file', file);
        formData.append('csrf_token', getCsrfToken());

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin.php?action=ajax_media_upload', true);

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const p = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = p + '%';
            }
        };

        xhr.onload = () => {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success && res.media) {
                    progressBar.style.width = '100%';
                    statusLabel.textContent = 'Upload complete!';

                    setTimeout(() => {
                        progressContainer.style.display = 'none';
                        progressBar.style.width = '0%';
                        // Switch to library tab and preselect new item
                        modalEl.querySelector('#tabLibraryBtn').click();
                        fetchPickerItems(res.media.id);
                    }, 600);
                } else {
                    statusLabel.textContent = 'Upload error: ' + (res.error || 'Failed');
                }
            } catch (err) {
                statusLabel.textContent = 'Error parsing server response';
            }
        };

        xhr.onerror = () => {
            statusLabel.textContent = 'Network error';
        };

        xhr.send(formData);
    }

    function open(options) {
        ensureModal();
        options = options || {};

        activeCallback = options.onSelect || null;
        selectedItem = null;

        const titleEl = modalEl.querySelector('#mediaPickerTitle');
        titleEl.textContent = options.title || 'Select Media';

        const notice = modalEl.querySelector('#pickerSelectedNotice');
        notice.textContent = 'No image selected';

        const selectBtn = modalEl.querySelector('#pickerSelectBtn');
        selectBtn.disabled = true;

        const sidebar = modalEl.querySelector('#pickerSidebar');
        sidebar.style.display = 'none';

        // Reset to library tab
        modalEl.querySelector('#tabLibraryBtn').click();

        modalEl.style.display = 'flex';
        fetchPickerItems();
    }

    function close() {
        if (modalEl) modalEl.style.display = 'none';
        activeCallback = null;
        selectedItem = null;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    return {
        open: open,
        close: close
    };
})();
