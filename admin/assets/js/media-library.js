/**
 * Calcutta Chaat & Bakery — WordPress-Style Media Library JavaScript
 */

(function () {
    'use strict';

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    // State
    const state = {
        view: 'grid', // 'grid' | 'list'
        page: 1,
        limit: 48,
        search: '',
        mime: '',
        month: '',
        items: [],
        total: 0,
        pages: 1,
        selectedIds: new Set(),
        bulkMode: false,
        activeDetailIndex: -1
    };

    // DOM Elements
    const dropzone = document.getElementById('mediaDropzone');
    const fileInput = document.getElementById('mediaFileInput');
    const dropzoneClickArea = document.getElementById('dropzoneClickArea');
    const btnToggleUpload = document.getElementById('btnToggleUpload');
    const btnSyncAssets = document.getElementById('btnSyncAssets');
    const uploadQueueContainer = document.getElementById('uploadQueueContainer');

    const viewGridBtn = document.getElementById('viewGridBtn');
    const viewListBtn = document.getElementById('viewListBtn');
    const filterMime = document.getElementById('filterMime');
    const filterMonth = document.getElementById('filterMonth');
    const mediaSearchInput = document.getElementById('mediaSearchInput');
    const mediaSearchClear = document.getElementById('mediaSearchClear');
    const btnBulkSelect = document.getElementById('btnBulkSelect');
    const btnBulkDelete = document.getElementById('btnBulkDelete');
    const bulkCountSpan = document.getElementById('bulkCount');

    const gridView = document.getElementById('mediaGridView');
    const listView = document.getElementById('mediaListView');
    const listTbody = document.getElementById('mediaListTbody');
    const selectAllList = document.getElementById('selectAllList');

    const pagination = document.getElementById('mediaPagination');
    const btnPrevPage = document.getElementById('btnPrevPage');
    const btnNextPage = document.getElementById('btnNextPage');
    const pageIndicator = document.getElementById('pageIndicator');
    const pageCurrentRange = document.getElementById('pageCurrentRange');
    const pageTotalItems = document.getElementById('pageTotalItems');

    // Stats Elements
    const statTotalCount = document.getElementById('statTotalCount');
    const statImageCount = document.getElementById('statImageCount');
    const statDiskUsage = document.getElementById('statDiskUsage');

    // Details Modal Elements
    const detailsModal = document.getElementById('attachmentDetailsModal');
    const closeAttachmentModal = document.getElementById('closeAttachmentModal');
    const prevAttachmentBtn = document.getElementById('prevAttachmentBtn');
    const nextAttachmentBtn = document.getElementById('nextAttachmentBtn');
    const detailPreviewImg = document.getElementById('detailPreviewImg');
    const detailFileName = document.getElementById('detailFileName');
    const detailMimeType = document.getElementById('detailMimeType');
    const detailUploadDate = document.getElementById('detailUploadDate');
    const detailFileSize = document.getElementById('detailFileSize');
    const detailDimensions = document.getElementById('detailDimensions');
    const detailItemId = document.getElementById('detailItemId');
    const detailAltText = document.getElementById('detailAltText');
    const detailTitle = document.getElementById('detailTitle');
    const detailCaption = document.getElementById('detailCaption');
    const detailFileUrl = document.getElementById('detailFileUrl');
    const btnCopyUrl = document.getElementById('btnCopyUrl');
    const copySuccessMsg = document.getElementById('copySuccessMsg');
    const btnDeletePermanent = document.getElementById('btnDeletePermanent');
    const attachmentMetaForm = document.getElementById('attachmentMetaForm');

    // Initialize
    loadMedia();

    // -------------------------------------------------------------
    // Fetch and Render Media
    // -------------------------------------------------------------
    function loadMedia() {
        const params = new URLSearchParams({
            action: 'ajax_media_list',
            page: state.page,
            limit: state.limit,
            s: state.search,
            mime: state.mime,
            month: state.month
        });

        if (state.view === 'grid') {
            gridView.innerHTML = `
                <div class="media-loading-placeholder">
                    <div class="spinner-sm" style="margin: 0 auto 10px;"></div>
                    <div>Loading media items...</div>
                </div>
            `;
        } else {
            listTbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">Loading media items...</td></tr>`;
        }

        fetch('/admin.php?' + params.toString())
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    showError('Failed to fetch media assets.');
                    return;
                }

                state.items = data.data.items || [];
                state.total = data.data.total || 0;
                state.pages = data.data.pages || 1;

                // Update Stats
                if (data.stats) {
                    if (statTotalCount) statTotalCount.textContent = data.stats.total_count;
                    if (statImageCount) statImageCount.textContent = data.stats.image_count;
                    if (statDiskUsage) statDiskUsage.textContent = data.stats.formatted_size;
                }

                renderMedia();
                renderPagination();
            })
            .catch(err => {
                showError('Network error while connecting to media storage.');
            });
    }

    function renderMedia() {
        if (state.items.length === 0) {
            const emptyHtml = `
                <div class="media-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: var(--text-muted);">
                    <div style="font-size: 40px; margin-bottom: 12px; opacity: 0.6;">📷</div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 4px;">No media items found</div>
                    <div style="font-size: 13px; max-width: 320px; margin: 0 auto 16px;">Upload images or adjust your search / filters to see uploaded assets.</div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('mediaFileInput').click()">Upload Files</button>
                </div>
            `;
            if (state.view === 'grid') {
                gridView.innerHTML = emptyHtml;
            } else {
                listTbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">No media items found.</td></tr>`;
            }
            return;
        }

        if (state.view === 'grid') {
            renderGrid();
        } else {
            renderList();
        }
    }

    function renderGrid() {
        gridView.innerHTML = '';
        state.items.forEach((item, index) => {
            const card = document.createElement('div');
            card.className = 'media-item-tile' + (state.selectedIds.has(item.id) ? ' is-selected' : '');
            card.setAttribute('data-id', item.id);

            const isImg = item.is_image;
            const thumbUrl = item.thumb_path || item.file_path;

            card.innerHTML = `
                <div class="media-tile-thumb">
                    ${isImg
                        ? `<img src="${escapeHtml(thumbUrl)}" alt="${escapeHtml(item.alt_text || item.title)}" loading="lazy" onerror="this.src='/favicon.ico'">`
                        : `<div class="media-tile-doc-icon">📄<br><span style="font-size: 10px;">${escapeHtml(item.mime_type.split('/')[1] || 'DOC')}</span></div>`
                    }
                    <div class="media-tile-check">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </div>
                <div class="media-tile-caption" title="${escapeHtml(item.title || item.filename)}">
                    ${escapeHtml(item.title || item.filename)}
                </div>
            `;

            card.addEventListener('click', (e) => {
                if (state.bulkMode) {
                    toggleSelect(item.id, card);
                } else {
                    openDetailModal(index);
                }
            });

            gridView.appendChild(card);
        });
    }

    function renderList() {
        listTbody.innerHTML = '';
        state.items.forEach((item, index) => {
            const tr = document.createElement('tr');
            const isSelected = state.selectedIds.has(item.id);
            if (isSelected) tr.classList.add('table-row-selected');

            const thumbUrl = item.thumb_path || item.file_path;
            const dimStr = (item.width && item.height) ? `${item.width} × ${item.height}` : '—';

            tr.innerHTML = `
                <td>
                    <input type="checkbox" class="list-item-checkbox" data-id="${item.id}" ${isSelected ? 'checked' : ''}>
                </td>
                <td>
                    <div class="media-list-thumb-box" style="cursor: pointer;">
                        ${item.is_image
                            ? `<img src="${escapeHtml(thumbUrl)}" alt="" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);" onerror="this.src='/favicon.ico'">`
                            : `<div style="width: 48px; height: 48px; background: var(--bg-subtle); display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px;">📄</div>`
                        }
                    </div>
                </td>
                <td>
                    <div style="font-weight: 700; color: var(--navy); cursor: pointer;" class="list-title-click">
                        ${escapeHtml(item.title || item.filename)}
                    </div>
                    <div style="font-size: 11.5px; color: var(--text-muted); font-family: monospace;">
                        ${escapeHtml(item.filename)}
                    </div>
                </td>
                <td style="font-size: 12.5px; color: var(--text-secondary);">${escapeHtml(dimStr)}</td>
                <td style="font-size: 12.5px; color: var(--text-secondary);">${escapeHtml(item.formatted_size)}</td>
                <td style="font-size: 12.5px; color: var(--text-secondary);">${escapeHtml(item.display_date)}</td>
                <td style="text-align: right;">
                    <button type="button" class="btn btn-secondary btn-sm btn-inspect-list" style="font-size: 11px; padding: 4px 8px;">
                        Edit Info
                    </button>
                </td>
            `;

            // Row click triggers
            tr.querySelector('.list-title-click').addEventListener('click', () => openDetailModal(index));
            tr.querySelector('.media-list-thumb-box').addEventListener('click', () => openDetailModal(index));
            tr.querySelector('.btn-inspect-list').addEventListener('click', () => openDetailModal(index));

            const cb = tr.querySelector('.list-item-checkbox');
            cb.addEventListener('change', () => {
                toggleSelect(item.id);
            });

            listTbody.appendChild(tr);
        });
    }

    function toggleSelect(id, tileEl) {
        if (state.selectedIds.has(id)) {
            state.selectedIds.delete(id);
            if (tileEl) tileEl.classList.remove('is-selected');
        } else {
            state.selectedIds.add(id);
            if (tileEl) tileEl.classList.add('is-selected');
        }
        updateBulkUI();
    }

    function updateBulkUI() {
        const count = state.selectedIds.size;
        bulkCountSpan.textContent = count;
        if (count > 0) {
            btnBulkDelete.style.display = 'inline-flex';
        } else {
            btnBulkDelete.style.display = 'none';
        }
    }

    function renderPagination() {
        if (state.total <= state.limit) {
            pagination.style.display = 'none';
            return;
        }

        pagination.style.display = 'flex';
        const start = (state.page - 1) * state.limit + 1;
        const end = Math.min(state.page * state.limit, state.total);
        pageCurrentRange.textContent = `${start}-${end}`;
        pageTotalItems.textContent = state.total;
        pageIndicator.textContent = `${state.page} / ${state.pages}`;

        btnPrevPage.disabled = state.page <= 1;
        btnNextPage.disabled = state.page >= state.pages;
    }

    // -------------------------------------------------------------
    // Toolbar Event Listeners
    // -------------------------------------------------------------
    viewGridBtn.addEventListener('click', () => {
        state.view = 'grid';
        viewGridBtn.classList.add('active');
        viewListBtn.classList.remove('active');
        gridView.style.display = 'grid';
        listView.style.display = 'none';
        renderMedia();
    });

    viewListBtn.addEventListener('click', () => {
        state.view = 'list';
        viewListBtn.classList.add('active');
        viewGridBtn.classList.remove('active');
        gridView.style.display = 'none';
        listView.style.display = 'block';
        renderMedia();
    });

    filterMime.addEventListener('change', () => {
        state.mime = filterMime.value;
        state.page = 1;
        loadMedia();
    });

    filterMonth.addEventListener('change', () => {
        state.month = filterMonth.value;
        state.page = 1;
        loadMedia();
    });

    let searchTimer = null;
    mediaSearchInput.addEventListener('input', (e) => {
        const val = e.target.value.trim();
        mediaSearchClear.style.display = val ? 'block' : 'none';
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            state.search = val;
            state.page = 1;
            loadMedia();
        }, 300);
    });

    mediaSearchClear.addEventListener('click', () => {
        mediaSearchInput.value = '';
        mediaSearchClear.style.display = 'none';
        state.search = '';
        state.page = 1;
        loadMedia();
    });

    btnBulkSelect.addEventListener('click', () => {
        state.bulkMode = !state.bulkMode;
        btnBulkSelect.textContent = state.bulkMode ? 'Cancel Selection' : 'Select Multiple';
        btnBulkSelect.classList.toggle('btn-primary', state.bulkMode);
        btnBulkSelect.classList.toggle('btn-secondary', !state.bulkMode);

        if (!state.bulkMode) {
            state.selectedIds.clear();
            updateBulkUI();
            renderMedia();
        }
    });

    if (selectAllList) {
        selectAllList.addEventListener('change', (e) => {
            const checked = e.target.checked;
            state.items.forEach(item => {
                if (checked) {
                    state.selectedIds.add(item.id);
                } else {
                    state.selectedIds.delete(item.id);
                }
            });
            updateBulkUI();
            renderList();
        });
    }

    btnBulkDelete.addEventListener('click', () => {
        const count = state.selectedIds.size;
        if (count === 0) return;
        if (!confirm(`Are you sure you want to permanently delete these ${count} media files? This cannot be undone.`)) {
            return;
        }

        const ids = Array.from(state.selectedIds);
        let deletedCount = 0;

        btnBulkDelete.disabled = true;
        btnBulkDelete.textContent = 'Deleting...';

        const promises = ids.map(id => {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('csrf_token', getCsrfToken());

            return fetch('/admin.php?action=ajax_media_delete', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) deletedCount++;
            });
        });

        Promise.all(promises).then(() => {
            state.selectedIds.clear();
            state.bulkMode = false;
            btnBulkSelect.textContent = 'Select Multiple';
            btnBulkSelect.classList.remove('btn-primary');
            btnBulkSelect.classList.add('btn-secondary');
            btnBulkDelete.disabled = false;
            updateBulkUI();
            loadMedia();
        });
    });

    btnPrevPage.addEventListener('click', () => {
        if (state.page > 1) {
            state.page--;
            loadMedia();
        }
    });

    btnNextPage.addEventListener('click', () => {
        if (state.page < state.pages) {
            state.page++;
            loadMedia();
        }
    });

    // -------------------------------------------------------------
    // Upload & Dropzone Management
    // -------------------------------------------------------------
    btnToggleUpload.addEventListener('click', () => {
        if (dropzone.style.display === 'none') {
            dropzone.style.display = 'block';
            dropzone.scrollIntoView({ behavior: 'smooth' });
        } else {
            dropzone.style.display = 'none';
        }
    });

    dropzoneClickArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files && fileInput.files.length > 0) {
            handleFilesUpload(Array.from(fileInput.files));
            fileInput.value = '';
        }
    });

    // Window Drag & Drop Listeners
    window.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.display = 'block';
        dropzone.classList.add('is-drag-over');
    });

    window.addEventListener('dragleave', (e) => {
        if (e.clientX <= 0 || e.clientY <= 0) {
            dropzone.classList.remove('is-drag-over');
        }
    });

    window.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('is-drag-over');
        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            handleFilesUpload(Array.from(e.dataTransfer.files));
        }
    });

    function handleFilesUpload(files) {
        if (!files || files.length === 0) return;
        uploadQueueContainer.style.display = 'block';

        let completed = 0;
        files.forEach(file => {
            uploadSingleFile(file, () => {
                completed++;
                if (completed === files.length) {
                    setTimeout(() => {
                        uploadQueueContainer.style.display = 'none';
                        uploadQueueContainer.innerHTML = '';
                        loadMedia();
                    }, 1200);
                }
            });
        });
    }

    function uploadSingleFile(file, onDone) {
        const row = document.createElement('div');
        row.className = 'upload-queue-item';
        row.innerHTML = `
            <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                <span style="font-weight: 600; color: var(--navy);">${escapeHtml(file.name)}</span>
                <span class="upload-percent" style="color: var(--text-muted);">0%</span>
            </div>
            <div class="upload-progress-track">
                <div class="upload-progress-bar" style="width: 0%;"></div>
            </div>
        `;
        uploadQueueContainer.prepend(row);

        const progressBar = row.querySelector('.upload-progress-bar');
        const percentLabel = row.querySelector('.upload-percent');

        const formData = new FormData();
        formData.append('file', file);
        formData.append('csrf_token', getCsrfToken());

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin.php?action=ajax_media_upload', true);

        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                percentLabel.textContent = percent + '%';
            }
        };

        xhr.onload = function () {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    progressBar.style.background = 'var(--success)';
                    percentLabel.textContent = '✓ Done';
                    percentLabel.style.color = 'var(--success-text)';
                } else {
                    progressBar.style.background = 'var(--danger)';
                    percentLabel.textContent = res.error || 'Failed';
                    percentLabel.style.color = 'var(--danger-text)';
                }
            } catch (err) {
                progressBar.style.background = 'var(--danger)';
                percentLabel.textContent = 'Error';
            }
            if (onDone) onDone();
        };

        xhr.onerror = function () {
            progressBar.style.background = 'var(--danger)';
            percentLabel.textContent = 'Network Error';
            if (onDone) onDone();
        };

        xhr.send(formData);
    }

    // -------------------------------------------------------------
    // Sync Physical Assets Tool
    // -------------------------------------------------------------
    btnSyncAssets.addEventListener('click', () => {
        btnSyncAssets.disabled = true;
        const origHtml = btnSyncAssets.innerHTML;
        btnSyncAssets.innerHTML = '<span>Scanning disk...</span>';

        const formData = new FormData();
        formData.append('csrf_token', getCsrfToken());

        fetch('/admin.php?action=ajax_media_sync', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            btnSyncAssets.disabled = false;
            btnSyncAssets.innerHTML = origHtml;
            if (res.success) {
                alert(`Asset sync complete! ${res.synced} new physical image(s) indexed.`);
                loadMedia();
            } else {
                alert('Sync failed: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(() => {
            btnSyncAssets.disabled = false;
            btnSyncAssets.innerHTML = origHtml;
            alert('Network error while syncing assets.');
        });
    });

    // -------------------------------------------------------------
    // WordPress-Style Attachment Details Modal
    // -------------------------------------------------------------
    function openDetailModal(index) {
        if (index < 0 || index >= state.items.length) return;
        state.activeDetailIndex = index;
        const item = state.items[index];

        detailItemId.value = item.id;
        detailFileName.textContent = item.filename;
        detailMimeType.textContent = item.mime_type;
        detailUploadDate.textContent = item.display_date;
        detailFileSize.textContent = item.formatted_size;
        detailDimensions.textContent = (item.width && item.height) ? `${item.width} × ${item.height} pixels` : 'Not available';

        detailAltText.value = item.alt_text || '';
        detailTitle.value = item.title || '';
        detailCaption.value = item.caption || '';
        detailFileUrl.value = window.location.origin + item.file_path;

        if (item.is_image) {
            detailPreviewImg.src = item.file_path;
            detailPreviewImg.style.display = 'block';
        } else {
            detailPreviewImg.style.display = 'none';
        }

        prevAttachmentBtn.disabled = index <= 0;
        nextAttachmentBtn.disabled = index >= state.items.length - 1;

        copySuccessMsg.style.display = 'none';
        detailsModal.style.display = 'flex';
    }

    function closeDetailModal() {
        detailsModal.style.display = 'none';
        state.activeDetailIndex = -1;
    }

    closeAttachmentModal.addEventListener('click', closeDetailModal);
    detailsModal.addEventListener('click', (e) => {
        if (e.target === detailsModal) closeDetailModal();
    });

    prevAttachmentBtn.addEventListener('click', () => {
        if (state.activeDetailIndex > 0) {
            openDetailModal(state.activeDetailIndex - 1);
        }
    });

    nextAttachmentBtn.addEventListener('click', () => {
        if (state.activeDetailIndex < state.items.length - 1) {
            openDetailModal(state.activeDetailIndex + 1);
        }
    });

    // Copy URL to clipboard
    btnCopyUrl.addEventListener('click', () => {
        detailFileUrl.select();
        navigator.clipboard.writeText(detailFileUrl.value).then(() => {
            copySuccessMsg.style.display = 'block';
            setTimeout(() => {
                copySuccessMsg.style.display = 'none';
            }, 2500);
        });
    });

    // Save Metadata (Alt text, title, caption)
    attachmentMetaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = parseInt(detailItemId.value, 10);
        if (!id) return;

        const saveBtn = document.getElementById('btnSaveMeta');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span>Saving...</span>';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('title', detailTitle.value.trim());
        formData.append('alt_text', detailAltText.value.trim());
        formData.append('caption', detailCaption.value.trim());
        formData.append('csrf_token', getCsrfToken());

        fetch('/admin.php?action=ajax_media_update', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<span>Save Changes</span>`;
            if (res.success) {
                // Update local item
                if (state.items[state.activeDetailIndex]) {
                    state.items[state.activeDetailIndex].title = detailTitle.value.trim();
                    state.items[state.activeDetailIndex].alt_text = detailAltText.value.trim();
                    state.items[state.activeDetailIndex].caption = detailCaption.value.trim();
                }
                renderMedia();
                closeDetailModal();
            } else {
                alert('Save failed: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<span>Save Changes</span>`;
            alert('Network error while saving metadata.');
        });
    });

    // Delete permanently from details modal
    btnDeletePermanent.addEventListener('click', () => {
        const id = parseInt(detailItemId.value, 10);
        if (!id) return;
        if (!confirm('Are you sure you want to permanently delete this media file? The file will be removed from disk.')) {
            return;
        }

        btnDeletePermanent.disabled = true;
        btnDeletePermanent.textContent = 'Deleting...';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', getCsrfToken());

        fetch('/admin.php?action=ajax_media_delete', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            btnDeletePermanent.disabled = false;
            btnDeletePermanent.textContent = 'Delete permanently';
            if (res.success) {
                closeDetailModal();
                loadMedia();
            } else {
                alert('Failed to delete: ' + (res.error || 'Server error'));
            }
        })
        .catch(() => {
            btnDeletePermanent.disabled = false;
            btnDeletePermanent.textContent = 'Delete permanently';
            alert('Network error while deleting media.');
        });
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showError(msg) {
        if (state.view === 'grid') {
            gridView.innerHTML = `<div style="grid-column: 1 / -1; text-align: center; color: var(--danger); padding: 2rem;">${escapeHtml(msg)}</div>`;
        } else {
            listTbody.innerHTML = `<tr><td colspan="7" style="text-align: center; color: var(--danger); padding: 2rem;">${escapeHtml(msg)}</td></tr>`;
        }
    }

})();
