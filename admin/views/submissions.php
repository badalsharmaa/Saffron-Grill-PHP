<?php
/**
 * Saffron Grill — Form Submissions & CRM Leads Manager
 * Fully optimized for Desktop, Tablets, and Mobile iOS/Android.
 */

$pageTitle = 'Form Submissions & CRM';
$currentPage = 'submissions';

// Filter parameters
$sourceFilter = trim((string)($_GET['source'] ?? 'all'));
$statusFilter = trim((string)($_GET['status'] ?? 'all'));
$searchQuery  = trim((string)($_GET['q'] ?? ''));

$stats = CMS::getLeadStats();

$filterArgs = [];
if ($sourceFilter !== '' && $sourceFilter !== 'all') {
    $filterArgs['source'] = $sourceFilter;
}
if ($statusFilter !== '' && $statusFilter !== 'all') {
    $filterArgs['status'] = $statusFilter;
}
if ($searchQuery !== '') {
    $filterArgs['search'] = $searchQuery;
}

$leads = CMS::getLeads($filterArgs);

require_once __DIR__ . '/components/header.php';
?>

<div style="padding-bottom: 3rem;">
    <!-- Apple-style Hero Header -->
    <div class="apple-header-card" style="margin-bottom: 2rem;">
        <div class="apple-header-icon-box" style="background: linear-gradient(135deg, rgba(197, 160, 89, 0.15), rgba(217, 119, 6, 0.2)); color: var(--gold);">
            <?= AdminIcons::get('inbox', 34) ?>
        </div>
        <h1 class="apple-header-title">Form Submissions &amp; Guest CRM</h1>
        <p class="apple-header-subtitle">
            Manage incoming table reservations, private event catering requests, customer messages, export submissions to CSV spreadsheets, and track follow-up stages.
        </p>
    </div>

    <!-- Bento KPI Cards Row -->
    <div class="crm-grid-3 lead-kpi-grid-mobile" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin-bottom: 1.25rem;">
        <!-- Total -->
        <div class="stat-card lead-kpi-card-compact" style="border-radius: 12px; background: #FFFFFF; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div class="stat-top" style="margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="stat-title" style="font-size: 11px; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); text-transform: uppercase;">Total</span>
                <div class="stat-icon-tile squircle-blue" style="width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('inbox', 14) ?>
                </div>
            </div>
            <div>
                <div class="stat-main-val" style="font-size: clamp(22px, 3.5vw, 26px); font-weight: 800; color: var(--navy);"><?= number_format($stats['total']) ?></div>
                <div class="stat-sub-val" style="font-size: 11px; color: var(--text-muted); margin-top: 1px;">Recorded leads</div>
            </div>
        </div>

        <!-- Reservations -->
        <div class="stat-card lead-kpi-card-compact" style="border-radius: 12px; background: #FFFFFF; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div class="stat-top" style="margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="stat-title" style="font-size: 11px; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); text-transform: uppercase;">Reservations</span>
                <div class="stat-icon-tile squircle-blue" style="width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('calendar', 14) ?>
                </div>
            </div>
            <div>
                <div class="stat-main-val" style="font-size: clamp(22px, 3.5vw, 26px); font-weight: 800; color: #0284C7;"><?= number_format($stats['reservations']) ?></div>
                <div class="stat-sub-val" style="font-size: 11px; color: var(--text-muted); margin-top: 1px;">Table bookings</div>
            </div>
        </div>

        <!-- Catering -->
        <div class="stat-card lead-kpi-card-compact" style="border-radius: 12px; background: #FFFFFF; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div class="stat-top" style="margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="stat-title" style="font-size: 11px; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); text-transform: uppercase;">Catering</span>
                <div class="stat-icon-tile squircle-orange" style="width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('utensils', 14) ?>
                </div>
            </div>
            <div>
                <div class="stat-main-val" style="font-size: clamp(22px, 3.5vw, 26px); font-weight: 800; color: var(--gold);"><?= number_format($stats['catering']) ?></div>
                <div class="stat-sub-val" style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 1px;">
                    <?= number_format($stats['total_guests']) ?> total guests
                </div>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="stat-card lead-kpi-card-compact" style="border-radius: 12px; background: #FFFFFF; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div class="stat-top" style="margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="stat-title" style="font-size: 11px; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); text-transform: uppercase;">Contact</span>
                <div class="stat-icon-tile squircle-purple" style="width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('mail', 14) ?>
                </div>
            </div>
            <div>
                <div class="stat-main-val" style="font-size: clamp(22px, 3.5vw, 26px); font-weight: 800; color: var(--navy);"><?= number_format($stats['contact']) ?></div>
                <div class="stat-sub-val" style="font-size: 11px; color: var(--text-muted); margin-top: 1px;">Customer messages</div>
            </div>
        </div>

        <!-- New & Unaddressed -->
        <div class="stat-card lead-kpi-card-compact" style="border-radius: 12px; border: 1px solid <?= $stats['new'] > 0 ? '#FDBA74' : 'var(--border-color)' ?>; background: <?= $stats['new'] > 0 ? 'linear-gradient(to bottom right, #FFFFFF, #FFFBF5)' : '#FFFFFF' ?>; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div class="stat-top" style="margin-bottom: 0.35rem; display: flex; justify-content: space-between; align-items: center;">
                <span class="stat-title" style="font-size: 11px; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); text-transform: uppercase;">New</span>
                <div class="stat-icon-tile" style="width: 28px; height: 28px; border-radius: 7px; background: rgba(217, 119, 6, 0.12); color: #D97706; display: flex; align-items: center; justify-content: center;">
                    <?= AdminIcons::get('clock', 14) ?>
                </div>
            </div>
            <div>
                <div class="stat-main-val" style="font-size: clamp(22px, 3.5vw, 26px); font-weight: 800; color: <?= $stats['new'] > 0 ? '#D97706' : 'var(--navy)' ?>;">
                    <?= number_format($stats['new']) ?>
                </div>
                <div class="stat-sub-val" style="font-size: 11px; color: var(--text-muted); margin-top: 1px;">Require response</div>
            </div>
        </div>
    </div>

    <!-- Filter Bar & Search Toolbar -->
    <div style="background: #FFFFFF; border-radius: 14px; border: 1px solid var(--border-color); padding: 1.1rem 1.25rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <form method="GET" action="/admin.php" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;">
            <input type="hidden" name="page" value="submissions">

            <!-- Source Filter Segmented Control -->
            <div style="display: inline-flex; background: #F1F5F9; padding: 4px; border-radius: 10px; gap: 3px; flex-wrap: wrap;">
                <?php 
                $tabs = [
                    'all' => 'All Inquiries',
                    'reservation' => 'Reservations',
                    'catering' => 'Catering',
                    'contact' => 'Contact',
                    'popup' => 'Popup VIP'
                ];
                foreach ($tabs as $k => $label): 
                    $isActive = ($sourceFilter === $k);
                ?>
                    <a href="/admin.php?page=submissions&source=<?= $k ?>&status=<?= urlencode($statusFilter) ?>&q=<?= urlencode($searchQuery) ?>" 
                       style="font-size: 12.5px; font-weight: <?= $isActive ? '700' : '600' ?>; padding: 6px 14px; border-radius: 7px; text-decoration: none; transition: all 0.2s ease; <?= $isActive ? 'background: #FFFFFF; color: var(--navy); box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #64748B;' ?>">
                        <?= e($label) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Status Dropdown, Search Input, and CSV Export -->
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <select name="status" class="form-control form-control-sm" style="width: auto; font-size: 12.5px; height: 36px; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Statuses</option>
                    <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>New</option>
                    <option value="contacted" <?= $statusFilter === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                    <option value="completed" <?= $statusFilter === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="archived" <?= $statusFilter === 'archived' ? 'selected' : '' ?>>Archived</option>
                </select>

                <div style="position: relative;">
                    <input type="text" name="q" value="<?= e($searchQuery) ?>" placeholder="Search name, phone..." class="form-control form-control-sm" style="padding-left: 30px; width: 190px; height: 36px; font-size: 12.5px; border-radius: 8px;">
                    <span style="position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: #94A3B8; pointer-events: none;">
                        <?= AdminIcons::get('search', 14) ?>
                    </span>
                </div>

                <button type="submit" class="btn btn-secondary btn-sm" style="height: 36px; padding: 0 12px; border-radius: 8px;">Filter</button>

                <a href="/admin.php?page=submissions&action=export_csv&source=<?= urlencode($sourceFilter) ?>&status=<?= urlencode($statusFilter) ?>" class="btn btn-secondary btn-sm" style="height: 36px; padding: 0 14px; gap: 6px; border-radius: 8px;" title="Export filtered records to spreadsheet">
                    <?= AdminIcons::get('download', 14) ?>
                    <span>Export CSV</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table & Submissions List -->
    <div style="background: #FFFFFF; border-radius: 14px; border: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
        <?php if (empty($leads)): ?>
            <div style="text-align: center; padding: 4.5rem 1.5rem; color: var(--text-muted);">
                <div style="width: 60px; height: 60px; margin: 0 auto 16px; border-radius: 16px; background: #FAF7F2; display: flex; align-items: center; justify-content: center; color: #CBD5E1;">
                    <?= AdminIcons::get('inbox', 28) ?>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 4px;">No Submissions Found</h3>
                <p style="font-size: 13.5px; max-width: 400px; margin: 0 auto; line-height: 1.5;">No records matched your active filter criteria. Try clearing search or status filters.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Guest / Client</th>
                            <th>Channel</th>
                            <th>Party / Guests</th>
                            <th>Date / Time</th>
                            <th>Summary Details</th>
                            <th>Status</th>
                            <th style="text-align: right; min-width: 140px;">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): 
                            $d = $lead['details'] ?? [];
                            $src = $lead['source'];
                            $srcLabel = match($src) {
                                'reservation', 'table_reservation' => 'Reservation',
                                'catering', 'catering_inquiry' => 'Catering',
                                'contact', 'contact_message' => 'Contact',
                                'popup', 'popup_lead' => 'Popup VIP',
                                default => ucfirst($src)
                            };
                            $srcBadgeBg = match($src) {
                                'reservation', 'table_reservation' => '#EFF6FF',
                                'catering', 'catering_inquiry' => '#FFFBEB',
                                'contact', 'contact_message' => '#F5F3FF',
                                default => '#F8FAFC'
                            };
                            $srcBadgeColor = match($src) {
                                'reservation', 'table_reservation' => '#0284C7',
                                'catering', 'catering_inquiry' => '#D97706',
                                'contact', 'contact_message' => '#7C3AED',
                                default => '#64748B'
                            };

                            $guests = $d['Guests'] ?? $d['guests'] ?? $d['party_size'] ?? '—';
                            $targetDate = $d['Reservation Date'] ?? $d['Event Date'] ?? date('M j, Y', strtotime($lead['created_at']));
                            $targetTime = $d['Reservation Time'] ?? '';
                            $leadJson = htmlspecialchars(json_encode($lead, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                            
                            $firstLetter = strtoupper(substr($lead['name'] ?: 'G', 0, 1));
                        ?>
                            <tr class="lead-table-row" onclick="openLeadModal(<?= $leadJson ?>)" style="cursor: pointer;">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 9px; background: #F1F5F9; color: var(--navy); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; flex-shrink: 0;">
                                            <?= e($firstLetter) ?>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--navy); font-size: 14px;">
                                                <?= e($lead['name'] ?: 'Guest') ?>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 1px;">
                                                <?php if (!empty($lead['phone'])): ?>
                                                    <span><?= e($lead['phone']) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($lead['email'])): ?>
                                                    <span style="margin-left: 6px; color: var(--text-muted);">&bull; <?= e($lead['email']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; padding: 4px 9px; border-radius: 6px; background: <?= $srcBadgeBg ?>; color: <?= $srcBadgeColor ?>; border: 1px solid <?= $srcBadgeColor ?>25;">
                                        <?= $srcLabel ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 3px 8px; border-radius: 6px;">
                                        <?= AdminIcons::get('users', 12) ?>
                                        <strong style="color: var(--navy); font-size: 12.5px;"><?= e($guests) ?></strong>
                                        <?= is_numeric($guests) ? '<small style="color:var(--text-muted); font-size:11px;">guests</small>' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px; font-weight: 600; color: var(--navy);"><?= e($targetDate) ?></div>
                                    <?php if ($targetTime): ?>
                                        <div style="font-size: 11.5px; color: var(--gold); font-weight: 700; margin-top: 1px;"><?= e($targetTime) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-size: 12.5px; color: var(--text-secondary); max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?php 
                                        $summaryParts = [];
                                        if (!empty($d['Booking Code'])) $summaryParts[] = '#' . $d['Booking Code'];
                                        if (!empty($d['Lead Code'])) $summaryParts[] = '#' . $d['Lead Code'];
                                        if (!empty($d['Reference Code'])) $summaryParts[] = '#' . $d['Reference Code'];
                                        if (!empty($d['Event Type'])) $summaryParts[] = $d['Event Type'];
                                        if (!empty($d['Package'])) $summaryParts[] = $d['Package'];
                                        if (!empty($d['Seating Area'])) $summaryParts[] = $d['Seating Area'];
                                        if (!empty($d['Notes'])) $summaryParts[] = $d['Notes'];
                                        if (!empty($lead['notes'])) $summaryParts[] = 'Staff: ' . $lead['notes'];
                                        echo e(implode(' · ', $summaryParts) ?: 'Inquiry received');
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-status status-<?= strtolower($lead['status']) ?>" style="font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                                        <?= ucfirst($lead['status']) ?>
                                    </span>
                                </td>
                                <td style="text-align: right;" onclick="event.stopPropagation();">
                                    <div style="display: inline-flex; align-items: center; gap: 6px;">
                                        <?php if (!empty($lead['phone'])): ?>
                                            <a href="tel:<?= e($lead['phone']) ?>" class="btn btn-secondary btn-sm" style="padding: 5px 8px; border-radius: 7px; color: #059669;" title="Call Guest">
                                                <?= AdminIcons::get('phone', 13) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($lead['email'])): ?>
                                            <a href="mailto:<?= e($lead['email']) ?>" class="btn btn-secondary btn-sm" style="padding: 5px 8px; border-radius: 7px; color: #2563EB;" title="Email Guest">
                                                <?= AdminIcons::get('mail', 13) ?>
                                            </a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="openLeadModal(<?= $leadJson ?>)" style="padding: 5px 10px; font-size: 12px; border-radius: 7px; font-weight: 600;">
                                            Details
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ======================================================================
     INTERACTIVE SUBMISSION DETAIL & CRM MODAL
     ====================================================================== -->
<div id="leadDetailModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
    <div class="modal-panel" style="background: #FFFFFF; border-radius: 18px; max-width: 620px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 2.25rem; position: relative; box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3); border: 1px solid #E2E8F0;">
        
        <!-- Close button -->
        <button type="button" onclick="closeLeadModal()" style="position: absolute; top: 16px; right: 18px; width: 32px; height: 32px; border-radius: 50%; background: #F1F5F9; border: none; font-size: 20px; color: #64748B; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">&times;</button>

        <!-- Header -->
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.75rem;">
            <div id="modalSourceBadge" style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 10px; border-radius: 6px;"></div>
            <div style="font-size: 12px; color: var(--text-muted);" id="modalCreatedAt"></div>
        </div>

        <h2 id="modalGuestName" style="font-size: 24px; font-weight: 800; color: var(--navy); margin-bottom: 6px;"></h2>

        <!-- Quick 1-tap contact buttons -->
        <div style="display: flex; gap: 10px; margin-bottom: 1.5rem; flex-wrap: wrap;">
            <a id="modalCallBtn" href="#" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 7px; border-radius: 8px; padding: 7px 14px;">
                <?= AdminIcons::get('phone', 14) ?>
                <span id="modalPhoneText">Call Guest</span>
            </a>
            <a id="modalEmailBtn" href="#" class="btn btn-secondary btn-sm" style="font-size: 13px; gap: 7px; border-radius: 8px; padding: 7px 14px;">
                <?= AdminIcons::get('mail', 14) ?>
                <span id="modalEmailText">Email Guest</span>
            </a>
        </div>

        <!-- Details Grid (macOS Grouped Aesthetic) -->
        <div style="background: #FAF7F2; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;">
            <h4 style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: var(--gold); margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                <?= AdminIcons::get('file-text', 13) ?>
                <span>Submission Attributes</span>
            </h4>
            <div id="modalDetailsContainer" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 13px;"></div>
        </div>

        <!-- Status update form -->
        <form method="POST" action="/admin.php?page=submissions&action=update_status" style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
            <input type="hidden" name="lead_id" id="statusLeadId" value="">

            <label class="form-label" style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #475569; margin-bottom: 6px;">Update Lead Processing Status</label>
            <div style="display: flex; gap: 10px;">
                <select name="status" id="modalStatusSelect" class="form-control" style="font-size: 13px; height: 42px; border-radius: 8px;">
                    <option value="new">New (Unaddressed)</option>
                    <option value="contacted">Contacted / In Discussion</option>
                    <option value="completed">Completed / Confirmed</option>
                    <option value="archived">Archived / Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="padding: 0 18px; white-space: nowrap; height: 42px; border-radius: 8px; font-weight: 700;">Update Status</button>
            </div>
        </form>

        <!-- Internal staff notes form -->
        <form method="POST" action="/admin.php?page=submissions&action=save_notes" style="margin-bottom: 1.5rem;">
            <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
            <input type="hidden" name="lead_id" id="notesLeadId" value="">

            <label class="form-label" style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #475569; margin-bottom: 6px;">Internal Staff &amp; Follow-up Notes</label>
            <textarea name="notes" id="modalNotesTextarea" class="form-control" rows="3" placeholder="Add private notes on table seating, dietary preferences, catering pricing discussions..." style="font-size: 13px; border-radius: 8px; line-height: 1.5;"></textarea>
            <div style="margin-top: 8px; text-align: right;">
                <button type="submit" class="btn btn-secondary btn-sm" style="font-size: 12.5px; border-radius: 7px; padding: 6px 14px; font-weight: 600;">Save Staff Notes</button>
            </div>
        </form>

        <!-- Delete record button -->
        <div style="display: flex; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-subtle);">
            <form method="POST" action="/admin.php?page=submissions&action=delete" onsubmit="return confirm('Permanently remove this submission record? This cannot be undone.');">
                <input type="hidden" name="csrf_token" value="<?= cms_generate_csrf() ?>">
                <input type="hidden" name="lead_id" id="deleteLeadId" value="">
                <button type="submit" class="btn btn-danger btn-sm" style="font-size: 12px; padding: 6px 12px; gap: 4px; border-radius: 7px;">
                    <?= AdminIcons::get('trash', 14) ?>
                    <span>Delete Record</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openLeadModal(lead) {
    if (!lead) return;

    document.getElementById('statusLeadId').value = lead.id;
    document.getElementById('notesLeadId').value = lead.id;
    document.getElementById('deleteLeadId').value = lead.id;

    document.getElementById('modalGuestName').textContent = lead.name || 'Anonymous Guest';
    document.getElementById('modalCreatedAt').textContent = 'Submitted on ' + lead.created_at;

    // Source badge
    var srcBadge = document.getElementById('modalSourceBadge');
    var src = lead.source;
    var srcLabel = src.toUpperCase();
    if (src === 'reservation' || src === 'table_reservation') {
        srcBadge.textContent = 'TABLE RESERVATION';
        srcBadge.style.background = '#0284C715';
        srcBadge.style.color = '#0284C7';
    } else if (src === 'catering' || src === 'catering_inquiry') {
        srcBadge.textContent = 'CATERING INQUIRY';
        srcBadge.style.background = '#D9770615';
        srcBadge.style.color = '#D97706';
    } else {
        srcBadge.textContent = src.toUpperCase();
        srcBadge.style.background = '#8B5CF615';
        srcBadge.style.color = '#8B5CF6';
    }

    // Contact buttons
    var callBtn = document.getElementById('modalCallBtn');
    var phoneText = document.getElementById('modalPhoneText');
    if (lead.phone) {
        callBtn.style.display = 'inline-flex';
        callBtn.href = 'tel:' + lead.phone;
        phoneText.textContent = lead.phone;
    } else {
        callBtn.style.display = 'none';
    }

    var emailBtn = document.getElementById('modalEmailBtn');
    var emailText = document.getElementById('modalEmailText');
    if (lead.email) {
        emailBtn.style.display = 'inline-flex';
        emailBtn.href = 'mailto:' + lead.email;
        emailText.textContent = lead.email;
    } else {
        emailBtn.style.display = 'none';
    }

    // Details grid
    var container = document.getElementById('modalDetailsContainer');
    container.innerHTML = '';
    var details = lead.details || {};

    for (var key in details) {
        if (details.hasOwnProperty(key)) {
            var val = details[key];
            if (val !== null && val !== '') {
                var itemDiv = document.createElement('div');
                itemDiv.innerHTML = '<span style="color:#64748B; font-weight:600; display:block; font-size:11px; text-transform:uppercase;">' + escapeHtml(key) + '</span><strong style="color:#0F172A;">' + escapeHtml(String(val)) + '</strong>';
                container.appendChild(itemDiv);
            }
        }
    }

    if (lead.ip_address) {
        var ipDiv = document.createElement('div');
        ipDiv.innerHTML = '<span style="color:#64748B; font-weight:600; display:block; font-size:11px; text-transform:uppercase;">IP Address</span><strong style="color:#0F172A;">' + escapeHtml(lead.ip_address) + '</strong>';
        container.appendChild(ipDiv);
    }

    // Status select
    var statusSelect = document.getElementById('modalStatusSelect');
    if (statusSelect) {
        statusSelect.value = lead.status || 'new';
    }

    // Notes
    document.getElementById('modalNotesTextarea').value = lead.notes || '';

    // Show modal
    var modal = document.getElementById('leadDetailModal');
    modal.style.display = 'flex';
}

function closeLeadModal() {
    var modal = document.getElementById('leadDetailModal');
    if (modal) modal.style.display = 'none';
}

function escapeHtml(str) {
    var p = document.createElement('p');
    p.textContent = str;
    return p.innerHTML;
}

// Close on backdrop click
document.getElementById('leadDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLeadModal();
    }
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
