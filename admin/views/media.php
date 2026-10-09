<?php
/**
 * Saffron Grill — WordPress-Style Media Library Hub
 */

$pageTitle = 'Media Library';
$currentPage = 'media';

$mediaStats = CMS::getMediaStats();
$mediaMonths = CMS::getMediaMonths();

require_once __DIR__ . '/components/header.php';
?>

<div class="media-library-view" style="font-size: 14px;">

    <!-- Top Action & Statistics Header -->
    <div class="apple-header-card" style="margin-bottom: 1.25rem; text-align: left; padding: 1.5rem 1.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div class="apple-header-icon-box" style="margin-bottom: 0; width: 48px; height: 48px; border-radius: 12px; background: rgba(14, 165, 233, 0.15); color: #0284C7;">
                    <?= AdminIcons::get('media_library', 24) ?>
                </div>
                <div>
                    <h1 class="apple-header-title" style="font-size: 20px; margin-bottom: 2px;">Media Library</h1>
                    <p class="apple-header-subtitle" style="font-size: 13px; max-width: none; color: var(--text-muted); margin: 0;">
                        Upload dishes, promo banners, and logos. Manage alternative text, titles, copy CDN links, and optimize web images.
                    </p>
                </div>
            </div>

            <!-- Header Quick Actions -->
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <button type="button" class="btn btn-secondary btn-sm" id="btnSyncAssets" title="Index any images physically placed on disk">
                    <?= AdminIcons::get('refresh', 14) ?>
                    <span>Sync Disk Assets</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btnToggleUpload">
                    <?= AdminIcons::get('upload', 14) ?>
                    <span>Add New Media</span>
                </button>
            </div>
        </div>

        <!-- KPI Metric Bar -->
        <div style="display: flex; gap: 1.5rem; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-color); flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 12px; color: var(--text-muted);">Total Assets:</span>
                <strong id="statTotalCount" style="color: var(--navy);"><?= $mediaStats['total_count'] ?></strong>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 12px; color: var(--text-muted);">Images:</span>
                <strong id="statImageCount" style="color: #0284C7;"><?= $mediaStats['image_count'] ?></strong>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 12px; color: var(--text-muted);">Disk Usage:</span>
                <strong id="statDiskUsage" style="color: var(--text-secondary);"><?= $mediaStats['formatted_size'] ?></strong>
            </div>
        </div>
    </div>

    <!-- Drag & Drop Upload Zone (Collapsible / Drop target) -->
    <div id="mediaDropzone" class="media-dropzone" style="display: none;">
        <input type="file" id="mediaFileInput" multiple accept="image/*,application/pdf" style="display: none;">
        <div class="media-dropzone-inner" id="dropzoneClickArea">
            <div class="media-dropzone-icon">
                <?= AdminIcons::get('upload', 36) ?>
            </div>
            <div style="font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 4px;">
                Drop files anywhere to upload
            </div>
            <div style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 14px;">
                or browse files from your computer (Images up to 15MB each, auto-optimized)
            </div>
            <button type="button" class="btn btn-primary btn-sm" style="pointer-events: none;">
                Select Files
            </button>
        </div>
        <!-- Upload Progress Queue -->
        <div id="uploadQueueContainer" class="upload-queue-container" style="display: none;"></div>
    </div>

    <!-- WordPress-Style Media Filter & Search Toolbar -->
    <div class="media-toolbar">
        <div class="media-toolbar-left">
            <!-- View Switcher (Grid / List) -->
            <div class="media-view-toggle">
                <button type="button" class="media-toggle-btn active" id="viewGridBtn" title="Grid View">
                    <?= AdminIcons::get('grid', 16) ?>
                </button>
                <button type="button" class="media-toggle-btn" id="viewListBtn" title="List View">
                    <?= AdminIcons::get('list', 16) ?>
                </button>
            </div>

            <!-- MIME Filter -->
            <select id="filterMime" class="form-control form-control-sm" style="width: auto; font-size: 12.5px;">
                <option value="">All media items</option>
                <option value="image">Images</option>
                <option value="document">Documents &amp; PDFs</option>
            </select>

            <!-- Month Filter -->
            <select id="filterMonth" class="form-control form-control-sm" style="width: auto; font-size: 12.5px;">
                <option value="">All dates</option>
                <?php foreach ($mediaMonths as $m): ?>
                    <option value="<?= e($m['value']) ?>"><?= e($m['label']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="media-toolbar-right">
            <div style="position: relative;">
                <input type="text" id="mediaSearchInput" class="form-control form-control-sm" placeholder="Search media..." style="padding-left: 28px; width: 220px; font-size: 12.5px;">
                <span style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: #94A3B8; pointer-events: none;">
                    <?= AdminIcons::get('search', 14) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Media Library Content Area -->
    <div id="mediaLoadingSpinner" class="media-loading" style="display: none;">
        <div class="spinner"></div>
        <span>Loading media assets...</span>
    </div>

    <!-- Grid View Container -->
    <div id="mediaGridContainer" class="media-grid"></div>

    <!-- List View Container (Hidden by default) -->
    <div id="mediaListContainer" class="media-list-table-wrap" style="display: none;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">File</th>
                    <th>Title &amp; Filename</th>
                    <th>MIME Type</th>
                    <th>Dimensions</th>
                    <th>Size</th>
                    <th>Date Uploaded</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="mediaListTbody"></tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="mediaEmptyState" class="media-empty-state" style="display: none;">
        <div class="media-empty-icon">
            <?= AdminIcons::get('picture', 32) ?>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 4px;">No Media Files Found</h3>
        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 1rem;">Upload images using the drag &amp; drop uploader above or sync disk assets.</p>
        <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('btnToggleUpload').click()">
            <?= AdminIcons::get('upload', 14) ?>
            <span>Upload Your First File</span>
        </button>
    </div>

    <!-- Pagination Controls -->
    <div id="mediaPagination" class="media-pagination" style="display: none;">
        <span id="paginationInfo" style="font-size: 12.5px; color: var(--text-muted);"></span>
        <div style="display: flex; gap: 6px;">
            <button type="button" class="btn btn-secondary btn-sm" id="btnPrevPage" disabled>Previous</button>
            <button type="button" class="btn btn-secondary btn-sm" id="btnNextPage" disabled>Next</button>
        </div>
    </div>
</div>

<!-- ======================================================================
     WORDPRESS-STYLE ATTACHMENT DETAIL INSPECTOR MODAL
     ====================================================================== -->
<div id="mediaInspectorModal" class="modal-backdrop" style="display: none;">
    <div class="media-inspector-dialog">
        <button type="button" class="media-modal-close" id="btnCloseInspector">&times;</button>
        
        <div class="media-inspector-body">
            <!-- Left: Big Preview Pane -->
            <div class="media-inspector-preview-pane">
                <div class="media-preview-box" id="inspectorPreviewBox"></div>
            </div>

            <!-- Right: Metadata & Form Controls -->
            <div class="media-inspector-meta-pane">
                <div class="inspector-file-header">
                    <h3 id="inspectorFileName" class="inspector-file-title">File Details</h3>
                    <div id="inspectorFileMeta" class="inspector-file-sub"></div>
                </div>

                <div class="inspector-field-group">
                    <label class="form-label" style="font-size: 12px;">Direct Public URL</label>
                    <div style="display: flex; gap: 6px;">
                        <input type="text" id="inspectorFileUrl" class="form-control form-control-sm" readonly style="font-size: 12px; font-family: monospace;">
                        <button type="button" class="btn btn-secondary btn-sm" id="btnCopyUrl" title="Copy to clipboard">Copy</button>
                    </div>
                </div>

                <form id="inspectorMetaForm" style="display: flex; flex-direction: column; gap: 10px;">
                    <input type="hidden" id="inspectorFileId">

                    <div class="inspector-field-group">
                        <label class="form-label" style="font-size: 12px;" for="inspectorTitle">Title</label>
                        <input type="text" id="inspectorTitle" class="form-control form-control-sm" placeholder="Title for this asset">
                    </div>

                    <div class="inspector-field-group">
                        <label class="form-label" style="font-size: 12px;" for="inspectorAltText">Alternative Text (Alt Text)</label>
                        <input type="text" id="inspectorAltText" class="form-control form-control-sm" placeholder="Describe purpose for screen readers / SEO">
                        <span style="font-size: 11px; color: var(--text-muted);">Leave empty if decorative.</span>
                    </div>

                    <div class="inspector-field-group">
                        <label class="form-label" style="font-size: 12px;" for="inspectorCaption">Caption</label>
                        <textarea id="inspectorCaption" class="form-control form-control-sm" rows="2" placeholder="Optional caption"></textarea>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--border-color);">
                        <button type="button" class="btn btn-danger btn-sm" id="btnDeleteMedia" style="font-size: 12px;">
                            <?= AdminIcons::get('trash', 14) ?>
                            <span>Delete File</span>
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnSaveMeta" style="font-size: 12px;">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/admin/assets/js/media-library.js?v=<?= time() ?>"></script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
