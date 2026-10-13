/**
 * Calcutta Chaat & Bakery — Custom CMS Client Interactivity
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Sidebar Toggle (Desktop Collapse & Mobile Drawer)
    const adminLayout = document.getElementById('adminLayout') || document.querySelector('.admin-layout');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarCollapseDesktop = document.getElementById('sidebarCollapseDesktop');

    // Desktop Collapse Toggle Logic
    function toggleDesktopSidebar(forceState) {
        if (!adminLayout) return;
        const isCurrentlyCollapsed = adminLayout.classList.contains('sidebar-collapsed') || document.documentElement.classList.contains('sidebar-is-collapsed');
        const shouldCollapse = (typeof forceState === 'boolean') ? forceState : !isCurrentlyCollapsed;

        if (shouldCollapse) {
            adminLayout.classList.add('sidebar-collapsed');
            document.documentElement.classList.add('sidebar-is-collapsed');
            localStorage.setItem('sg_sidebar_collapsed', 'true');
            if (sidebarToggle) sidebarToggle.setAttribute('title', 'Expand Sidebar (⌘[)');
        } else {
            adminLayout.classList.remove('sidebar-collapsed');
            document.documentElement.classList.remove('sidebar-is-collapsed');
            localStorage.setItem('sg_sidebar_collapsed', 'false');
            if (sidebarToggle) sidebarToggle.setAttribute('title', 'Collapse Sidebar (⌘[)');
        }

        // Trigger resize event for charts/customizer canvas
        window.dispatchEvent(new Event('resize'));
    }

    // Initialize desktop collapsed state from localStorage
    if (window.innerWidth > 900) {
        const savedCollapsed = localStorage.getItem('sg_sidebar_collapsed') === 'true';
        if (savedCollapsed) {
            if (adminLayout) adminLayout.classList.add('sidebar-collapsed');
            document.documentElement.classList.add('sidebar-is-collapsed');
            if (sidebarToggle) sidebarToggle.setAttribute('title', 'Expand Sidebar (⌘[)');
        }
    }

    // Dedicated Desktop Collapse Button inside Sidebar Header
    if (sidebarCollapseDesktop) {
        sidebarCollapseDesktop.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleDesktopSidebar(true);
        });
    }

    // Mobile Sidebar Drawer Toggle & Overlay
    function openMobileSidebar() {
        if (adminSidebar) adminSidebar.classList.add('open');
        if (sidebarOverlay) sidebarOverlay.classList.add('active');
        document.body.classList.add('sidebar-locked');
    }

    function closeMobileSidebar() {
        if (adminSidebar) adminSidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('active');
        document.body.classList.remove('sidebar-locked');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            if (window.innerWidth > 900) {
                // Desktop: Toggle between full rail and mini icon-only rail
                toggleDesktopSidebar();
            } else {
                // Mobile/Tablet: Open or close drawer
                if (adminSidebar && adminSidebar.classList.contains('open')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            }
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', function (e) {
            e.stopPropagation();
            closeMobileSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    // Close on Escape key press or Toggle on Cmd + [
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && adminSidebar && adminSidebar.classList.contains('open')) {
            closeMobileSidebar();
        }
        // Keyboard shortcut: Cmd+[ or Ctrl+[ toggles desktop sidebar
        if ((e.metaKey || e.ctrlKey) && (e.key === '[' || e.key === 'b')) {
            if (window.innerWidth > 900) {
                e.preventDefault();
                toggleDesktopSidebar();
            }
        }
    });

    // 2. Universal Search filter shortcut (Cmd + K or Ctrl + K)
    const searchInput = document.getElementById('adminSidebarSearch');
    window.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase().trim();
            const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
            navItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = query === '' || text.includes(query) ? 'flex' : 'none';
            });
        });
    }

    // --- Image Upload & Media Gallery Utility ---
    function getCsrfToken() {
        if (window.CMS_CSRF) return window.CMS_CSRF;
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function uploadImageAjax(file, onSuccess, onError, onProgress) {
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('csrf_token', getCsrfToken());

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin.php?action=ajax_upload_image', true);
        if (onProgress && xhr.upload) {
            xhr.upload.onprogress = onProgress;
        }

        xhr.onload = function () {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success && res.url) {
                    if (onSuccess) onSuccess(res.url, res.filename);
                } else {
                    if (onError) onError(res.error || 'Upload failed.');
                }
            } catch (err) {
                if (onError) onError('Invalid server response during image upload.');
            }
        };

        xhr.onerror = function () {
            if (onError) onError('Network error occurred while uploading image.');
        };

        xhr.send(formData);
    }

    // Media Gallery Modal Handler (Uses CMSMediaPicker if available, fallbacks to legacy modal)
    const mediaGalleryModal = document.getElementById('mediaGalleryModal');
    const closeGalleryModal = document.getElementById('closeGalleryModal');
    const cancelGalleryModal = document.getElementById('cancelGalleryModal');
    const galleryGrid = document.getElementById('galleryGrid');
    const galleryUploadInput = document.getElementById('galleryUploadInput');
    let activeGalleryCallback = null;

    function openGalleryModal(onSelect) {
        if (window.CMSMediaPicker) {
            window.CMSMediaPicker.open({
                title: 'Select Flyer or Promotional Image',
                onSelect: function(item) {
                    if (onSelect) onSelect(item.file_path);
                }
            });
            return;
        }

        activeGalleryCallback = onSelect;
        if (!mediaGalleryModal) return;
        mediaGalleryModal.style.display = 'flex';
        loadGalleryImages();
    }

    function closeGallery() {
        if (mediaGalleryModal) mediaGalleryModal.style.display = 'none';
        activeGalleryCallback = null;
    }

    if (closeGalleryModal) closeGalleryModal.addEventListener('click', closeGallery);
    if (cancelGalleryModal) cancelGalleryModal.addEventListener('click', closeGallery);
    if (mediaGalleryModal) {
        mediaGalleryModal.addEventListener('click', function (e) {
            if (e.target === mediaGalleryModal) closeGallery();
        });
    }

    function loadGalleryImages() {
        if (!galleryGrid) return;
        galleryGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 2rem;">Loading images...</div>';

        fetch('/admin.php?action=ajax_list_images')
            .then(res => res.json())
            .then(data => {
                if (!data.success || !Array.isArray(data.images) || data.images.length === 0) {
                    galleryGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 2rem;">No images found in gallery yet. Upload one!</div>';
                    return;
                }

                galleryGrid.innerHTML = '';
                data.images.forEach(img => {
                    const item = document.createElement('div');
                    item.className = 'gallery-item-card';
                    item.style.cssText = 'border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; cursor: pointer; transition: all 0.15s ease; background: #fff; text-align: center; padding: 6px;';
                    item.innerHTML = `
                        <img src="${img.url}" alt="${img.name}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 6px; display: block;" onerror="this.src='/favicon.ico'">
                        <div style="font-size: 11px; color: var(--navy); margin-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;" title="${img.name}">
                            ${img.name}
                        </div>
                    `;

                    item.addEventListener('mouseenter', () => {
                        item.style.borderColor = 'var(--primary)';
                        item.style.boxShadow = 'var(--shadow-md)';
                        item.style.transform = 'translateY(-2px)';
                    });
                    item.addEventListener('mouseleave', () => {
                        item.style.borderColor = 'var(--border-color)';
                        item.style.boxShadow = 'none';
                        item.style.transform = 'none';
                    });

                    item.addEventListener('click', () => {
                        if (activeGalleryCallback) {
                            activeGalleryCallback(img.url);
                        }
                        closeGallery();
                    });

                    galleryGrid.appendChild(item);
                });
            })
            .catch(() => {
                galleryGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; color: var(--danger); padding: 2rem;">Failed to load images from server.</div>';
            });
    }

    if (galleryUploadInput) {
        galleryUploadInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const uploadLabel = galleryUploadInput.closest('label');
            const originalText = uploadLabel ? uploadLabel.innerHTML : '';
            if (uploadLabel) uploadLabel.innerHTML = '<span>Uploading...</span>';

            uploadImageAjax(file, (url) => {
                if (uploadLabel) uploadLabel.innerHTML = originalText;
                loadGalleryImages();
                if (activeGalleryCallback) {
                    activeGalleryCallback(url);
                    closeGallery();
                }
            }, (err) => {
                if (uploadLabel) uploadLabel.innerHTML = originalText;
                alert('Upload failed: ' + err);
            });
        });
    }

    // Generic Image File Uploaders (e.g. for About Page or other inputs)
    document.querySelectorAll('.ajax-image-file-uploader').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const targetInputId = this.getAttribute('data-target-input');
            const targetThumbId = this.getAttribute('data-target-thumb');
            const targetInput = document.getElementById(targetInputId);
            const targetThumb = document.getElementById(targetThumbId);
            const parentLabel = this.closest('label');
            const origText = parentLabel ? parentLabel.querySelector('span').textContent : '';

            if (parentLabel) parentLabel.querySelector('span').textContent = 'Uploading...';

            uploadImageAjax(file, (url) => {
                if (parentLabel) parentLabel.querySelector('span').textContent = origText;
                if (targetInput) targetInput.value = url;
                if (targetThumb) targetThumb.src = url;
            }, (err) => {
                if (parentLabel) parentLabel.querySelector('span').textContent = origText;
                alert('Image upload failed: ' + err);
            });
        });
    });

    // 3. Dynamic Slide Management in Popup Manager
    const addSlideBtn = document.getElementById('addSlideBtn');
    const slidesContainer = document.getElementById('slidesContainer');

    function attachSlideListeners(card) {
        const removeBtn = card.querySelector('.remove-slide-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                const allCards = slidesContainer.querySelectorAll('.slide-card');
                if (allCards.length <= 1) {
                    alert('You must have at least one slide in the popup.');
                    return;
                }
                card.remove();
            });
        }

        const imgInput = card.querySelector('.slide-img-input');
        const thumb = card.querySelector('.preview-thumb');
        if (imgInput && thumb) {
            imgInput.addEventListener('input', function () {
                thumb.src = imgInput.value.trim() || '/favicon.ico';
            });
        }

        // Slide Image Upload Button
        const fileInput = card.querySelector('.slide-file-input');
        const uploadBtn = card.querySelector('.slide-upload-btn');
        if (fileInput && uploadBtn) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                const span = uploadBtn.querySelector('span');
                const prevText = span ? span.textContent : 'Upload';
                if (span) span.textContent = 'Uploading...';
                uploadBtn.style.opacity = '0.7';

                uploadImageAjax(file, (url) => {
                    if (span) span.textContent = prevText;
                    uploadBtn.style.opacity = '1';
                    if (imgInput) imgInput.value = url;
                    if (thumb) thumb.src = url;
                }, (err) => {
                    if (span) span.textContent = prevText;
                    uploadBtn.style.opacity = '1';
                    alert('Slide image upload failed: ' + err);
                });
            });
        }

        // Slide Gallery Picker Button
        const galleryBtn = card.querySelector('.slide-gallery-btn');
        if (galleryBtn) {
            galleryBtn.addEventListener('click', function () {
                openGalleryModal((chosenUrl) => {
                    if (imgInput) imgInput.value = chosenUrl;
                    if (thumb) thumb.src = chosenUrl;
                });
            });
        }
    }

    if (slidesContainer) {
        document.querySelectorAll('.slide-card').forEach(attachSlideListeners);
    }

    if (addSlideBtn && slidesContainer) {
        addSlideBtn.addEventListener('click', function () {
            const count = slidesContainer.querySelectorAll('.slide-card').length;
            const newIndex = count + 1;
            const card = document.createElement('div');
            card.className = 'slide-card';
            card.innerHTML = `
                <div class="slide-thumb-col" style="display: flex; flex-direction: column; align-items: center; gap: 6px; width: 110px; flex-shrink: 0;">
                    <img src="/assets/popup/2Jun.webp" alt="Slide ${newIndex}" class="slide-thumb preview-thumb" onerror="this.src='/favicon.ico'" style="width: 80px; height: 110px; border-radius: 8px;">
                    <label class="btn btn-primary btn-sm slide-upload-btn" style="cursor: pointer; width: 100%; font-size: 11.5px; padding: 5px 8px; justify-content: center;" title="Upload new image from your device">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span>Upload</span>
                        <input type="file" accept="image/*" class="slide-file-input" style="display: none;">
                    </label>
                    <button type="button" class="btn btn-secondary btn-sm slide-gallery-btn" style="width: 100%; font-size: 11.5px; padding: 5px 8px; justify-content: center;" title="Choose from existing flyers">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        <span>Gallery</span>
                    </button>
                </div>

                <div class="slide-details">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">
                            <span>Image Path / URL</span>
                            <span class="form-help" style="font-size: 11px; color: var(--primary);">Auto-fills on upload</span>
                        </label>
                        <input type="text" name="slides[${count}][image]" value="/assets/popup/2Jun.webp" class="form-control slide-img-input" placeholder="/assets/popup/..." required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Title / Caption</label>
                        <input type="text" name="slides[${count}][title]" value="Special Offer" class="form-control" placeholder="e.g. Special Offer">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">CTA Link</label>
                        <input type="text" name="slides[${count}][link]" value="/order" class="form-control" placeholder="e.g. /order">
                    </div>
                    <input type="hidden" name="slides[${count}][alt]" value="Slide ${newIndex}">
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-slide-btn" title="Delete Slide">
                    &times;
                </button>
            `;
            slidesContainer.appendChild(card);
            attachSlideListeners(card);
        });
    }

    // 4. Combined Filter for Menu Manager (Search, Category, and Location)
    const menuSearchInput = document.getElementById('menuSearchInput');
    const categoryTabs = document.querySelectorAll('.category-filter-tab');
    const locationTabs = document.querySelectorAll('.location-tab-btn');
    const countIndicator = document.getElementById('menuRowCountIndicator');

    let currentSearch = '';
    let currentCategory = 'all';
    let currentLocation = 'all';

    function applyMenuFilters() {
        const rows = document.querySelectorAll('.menu-item-row');
        const mobileCards = document.querySelectorAll('.dish-card-mobile');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = (row.getAttribute('data-name') || '').toLowerCase();
            const cat = (row.getAttribute('data-category') || '').toLowerCase();
            const locs = (row.getAttribute('data-locations') || '').toLowerCase();

            const matchesSearch = currentSearch === '' || name.includes(currentSearch) || cat.includes(currentSearch);
            const matchesCategory = currentCategory === 'all' || cat === currentCategory.toLowerCase();
            const matchesLocation = currentLocation === 'all' || locs.includes(currentLocation);

            if (matchesSearch && matchesCategory && matchesLocation) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        mobileCards.forEach(card => {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const cat = (card.getAttribute('data-category') || '').toLowerCase();
            const locs = (card.getAttribute('data-locations') || '').toLowerCase();

            const matchesSearch = currentSearch === '' || name.includes(currentSearch) || cat.includes(currentSearch);
            const matchesCategory = currentCategory === 'all' || cat === currentCategory.toLowerCase();
            const matchesLocation = currentLocation === 'all' || locs.includes(currentLocation);

            if (matchesSearch && matchesCategory && matchesLocation) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        if (countIndicator) {
            countIndicator.innerHTML = `Showing <strong>${visibleCount}</strong> of <strong>${rows.length}</strong> active dishes.`;
        }

        // Highlight column based on location selection
        const fremontCols = document.querySelectorAll('.col-fremont-price');
        const milpitasCols = document.querySelectorAll('.col-milpitas-price');

        fremontCols.forEach(col => {
            if (currentLocation === 'fremont') {
                col.style.backgroundColor = 'rgba(234, 88, 12, 0.05)';
            } else {
                col.style.backgroundColor = '';
            }
        });

        milpitasCols.forEach(col => {
            if (currentLocation === 'milpitas') {
                col.style.backgroundColor = 'rgba(37, 99, 235, 0.05)';
            } else {
                col.style.backgroundColor = '';
            }
        });
    }

    window.applyMenuFilters = applyMenuFilters;

    if (menuSearchInput) {
        menuSearchInput.addEventListener('input', function (e) {
            currentSearch = e.target.value.toLowerCase().trim();
            applyMenuFilters();
        });
    }

    if (categoryTabs.length > 0) {
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                categoryTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                currentCategory = tab.getAttribute('data-cat-id');
                applyMenuFilters();
            });
        });
    }

    if (locationTabs.length > 0) {
        locationTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                locationTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                currentLocation = tab.getAttribute('data-loc');
                applyMenuFilters();
            });
        });
    }

    // 5. Sync color picker with adjacent hex input
    const colorPickers = document.querySelectorAll('input[type="color"]');
    colorPickers.forEach(picker => {
        picker.addEventListener('input', function () {
            const nextInput = picker.nextElementSibling;
            if (nextInput && nextInput.tagName === 'INPUT') {
                nextInput.value = picker.value.toUpperCase();
            }
        });
    });
});
