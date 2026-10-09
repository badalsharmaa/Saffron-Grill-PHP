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
                <option value="document">Documents & PDFs</option>
            </select>

            <!-- Month Filter -->
            <select id="filterMonth" class="form-control form-control-sm" style="width: auto; font-size: 12.5px;">
                <option value="">All dates</option>
                <?php foreach ($mediaMonths as $m): ?>
                    <option value="<?= e($m['value']) ?>"><?= e($m['label']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Bulk Select Mode Toggle -->
            <button type="button" class="btn btn-secondary btn-sm" id="btnBulkSelect">
                Select Multiple
            </button>
            <button type="button" class="btn btn-danger btn-sm" id="btnBulkDelete" style="display: none;">
                Delete Selected (<span id="bulkCount">0</span>)
            </button>
        </div>

        <div class="media-toolbar-right">
            <!-- Search Bar -->
            <div class="media-search-wrap">
                <span class="media-search-icon">
                    <?= AdminIcons::get('search', 14) ?>
                </span>
                <input type="text" id="mediaSearchInput" class="form-control form-control-sm" placeholder="Search media items..." autocomplete="off">
                <button type="button" id="mediaSearchClear" class="media-search-clear" style="display: none;">&times;</button>
            </div>
        </div>
    </div>

    <!-- Media Library Content Area -->
    <div class="media-content-container">
        <!-- GRID VIEW (Default) -->
        <div id="mediaGridView" class="media-grid">
            <div class="media-loading-placeholder">
                <div class="spinner-sm" style="margin: 0 auto 10px;"></div>
                <div>Loading media items...</div>
            </div>
        </div>

        <!-- LIST VIEW (Tabular) -->
        <div id="mediaListView" class="media-list-table-wrap" style="display: none;">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" id="selectAllList"></th>
                        <th style="width: 70px;">Thumbnail</th>
                        <th>File Name & Title</th>
                        <th>Dimensions</th>
                        <th>File Size</th>
                        <th>Date Uploaded</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody id="mediaListTbody">
                    <tr><td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">Loading media items...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div class="media-pagination-bar" id="mediaPagination" style="display: none;">
            <div style="font-size: 12px; color: var(--text-muted);">
                Showing <span id="pageCurrentRange">0-0</span> of <strong id="pageTotalItems">0</strong> items
            </div>
            <div style="display: flex; gap: 6px;">
                <button type="button" class="btn btn-secondary btn-sm" id="btnPrevPage" disabled>
                    <?= AdminIcons::get('chevron_left', 14) ?>
                    <span>Previous</span>
                </button>
                <span id="pageIndicator" style="display: flex; align-items: center; padding: 0 8px; font-size: 12px; font-weight: 600; color: var(--navy);">1 / 1</span>
                <button type="button" class="btn btn-secondary btn-sm" id="btnNextPage" disabled>
                    <span>Next</span>
                    <?= AdminIcons::get('chevron_right', 14) ?>
                </button>
            </div>
        </div>
    </div>

</div>

<!-- ======================================================================
     WORDPRESS-STYLE ATTACHMENT DETAILS MODAL / DRAWER
     ====================================================================== -->
<div id="attachmentDetailsModal" class="modal-backdrop" style="display: none;">
    <div class="attachment-modal-card">
        <!-- Modal Top Bar -->
        <div class="attachment-modal-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <?= AdminIcons::get('info', 18) ?>
                <h3 style="font-size: 16px; font-weight: 700; color: var(--navy); margin: 0;">Attachment Details</h3>
            </div>
            <div style="display: flex; gap: 6px; align-items: center;">
                <button type="button" id="prevAttachmentBtn" class="btn btn-secondary btn-sm" title="Previous Image">
                    <?= AdminIcons::get('chevron_left', 14) ?>
                </button>
                <button type="button" id="nextAttachmentBtn" class="btn btn-secondary btn-sm" title="Next Image">
                    <?= AdminIcons::get('chevron_right', 14) ?>
                </button>
                <button type="button" id="closeAttachmentModal" class="attachment-close-btn">&times;</button>
            </div>
        </div>

        <!-- Modal Body: Left Preview, Right Inspector -->
        <div class="attachment-modal-body">
            <!-- Left: Large Preview Canvas -->
            <div class="attachment-preview-canvas">
                <div class="attachment-preview-box">
                    <img id="detailPreviewImg" src="" alt="" onerror="this.src='/favicon.ico'">
                </div>
            </div>

            <!-- Right: Metadata & Editable Fields -->
            <div class="attachment-details-pane">
                <!-- Readonly Specs Summary -->
                <div class="attachment-meta-summary">
                    <div class="meta-row">
                        <span class="meta-label">File name:</span>
                        <strong class="meta-value" id="detailFileName" style="word-break: break-all;">-</strong>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">File type:</span>
                        <span class="meta-value" id="detailMimeType">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Uploaded on:</span>
                        <span class="meta-value" id="detailUploadDate">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">File size:</span>
                        <span class="meta-value" id="detailFileSize">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Dimensions:</span>
                        <span class="meta-value" id="detailDimensions">-</span>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 12px 0;">

                <!-- Editable Fields -->
                <form id="attachmentMetaForm">
                    <input type="hidden" id="detailItemId" value="0">

                    <!-- Alternative Text -->
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Alternative Text (Alt Text)</label>
                        <input type="text" id="detailAltText" class="form-control form-control-sm" placeholder="Describe the image for screen readers & SEO">
                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 3px;">
                            Important for accessibility and Google Image search ranking.
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Title</label>
                        <input type="text" id="detailTitle" class="form-control form-control-sm" placeholder="Display title">
                    </div>

                    <!-- Caption -->
                    <div class="form-group" style="margin-bottom: 14px;">
                        <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Caption</label>
                        <textarea id="detailCaption" class="form-control form-control-sm" rows="2" placeholder="Optional caption"></textarea>
                    </div>

                    <!-- File URL & Copy -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">File URL</label>
                        <div style="display: flex; gap: 6px;">
                            <input type="text" id="detailFileUrl" class="form-control form-control-sm" readonly style="background: var(--bg-subtle); font-family: monospace; font-size: 11px;">
                            <button type="button" id="btnCopyUrl" class="btn btn-secondary btn-sm" title="Copy URL">
                                <?= AdminIcons::get('copy', 13) ?>
                                <span>Copy</span>
                            </button>
                        </div>
                        <span id="copySuccessMsg" style="display: none; font-size: 11px; color: var(--success-text); margin-top: 3px;">Copied to clipboard!</span>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid var(--border-color);">
                        <button type="button" id="btnDeletePermanent" class="btn-link-danger" style="font-size: 12px;">
                            Delete permanently
                        </button>
                        <button type="submit" id="btnSaveMeta" class="btn btn-primary btn-sm">
                            <?= AdminIcons::get('check', 14) ?>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/admin/assets/js/media-library.js"></script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
