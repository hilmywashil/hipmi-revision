{{-- resources/views/admin/katalog/partials/inspect-modal.blade.php --}}

<style>
    /* Inspect Modal Styles */
    .inspect-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        overflow-y: auto;
    }

    .inspect-modal.show {
        display: flex;
    }

    .inspect-modal-content {
        background: white;
        border-radius: 20px;
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalSlideUp 0.3s ease;
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .inspect-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2rem 1.5rem;
        border-bottom: 2px solid #f1f5f9;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
        border-radius: 20px 20px 0 0;
    }

    .inspect-modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .inspect-modal-close {
        background: #f1f5f9;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        cursor: pointer;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 1.5rem;
    }

    .inspect-modal-close:hover {
        background: #e2e8f0;
        color: #334155;
        transform: rotate(90deg);
    }

    .inspect-modal-body {
        padding: 2rem;
    }

    /* Katalog Preview Card */
    .katalog-preview {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .preview-header {
        display: flex;
        gap: 1.5rem;
        align-items: start;
        margin-bottom: 2rem;
    }

    .preview-logo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 16px;
        border: 3px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .preview-info {
        flex: 1;
    }

    .preview-company-name {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .preview-business-field {
        display: inline-block;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #78350f;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 700;
        margin-bottom: 1rem;
        border: 1px solid #fbbf24;
    }

    .preview-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 700;
        margin-left: 0.5rem;
    }

    .preview-status-badge.pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .detail-item {
        background: white;
        padding: 1.25rem;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
    }

    .detail-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-label svg {
        width: 14px;
        height: 14px;
    }

    .detail-value {
        font-size: 0.9375rem;
        color: #0f172a;
        font-weight: 600;
    }

    .detail-value.large {
        font-size: 1.125rem;
        font-weight: 700;
    }

    /* Description Section */
    .description-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        margin-bottom: 2rem;
    }

    .description-section h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .description-text {
        color: #475569;
        line-height: 1.7;
        font-size: 0.9375rem;
    }

    /* Creator Section */
    .creator-section {
        background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #fde68a;
        margin-bottom: 2rem;
    }

    .creator-section h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #78350f;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .creator-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: white;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #fbbf24;
    }

    .creator-avatar-large {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
        background: #fef3c7;
        color: #78350f;
        border: 2px solid #fbbf24;
    }

    .creator-info-large {
        flex: 1;
    }

    .creator-name-large {
        font-size: 1.125rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .creator-meta-large {
        color: #64748b;
        font-size: 0.875rem;
    }

    /* Modal Actions */
    .inspect-modal-actions {
        display: flex;
        gap: 1rem;
        padding: 1.5rem 2rem 2rem;
        border-top: 2px solid #f1f5f9;
        position: sticky;
        bottom: 0;
        background: white;
        border-radius: 0 0 20px 20px;
    }

    .inspect-modal-actions button,
    .inspect-modal-actions a {
        flex: 1;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9375rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-inspect-close {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-inspect-close:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }

    .btn-inspect-reject {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
    }

    .btn-inspect-reject:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }

    .btn-inspect-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-inspect-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .inspect-modal {
            padding: 1rem;
        }

        .inspect-modal-content {
            max-height: 95vh;
        }

        .preview-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .inspect-modal-actions {
            flex-direction: column;
        }
    }
</style>

<!-- Inspect Modal -->
<div id="inspectModal" class="inspect-modal">
    <div class="inspect-modal-content">
        <div class="inspect-modal-header">
            <h3>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Inspect Katalog
            </h3>
            <button class="inspect-modal-close" onclick="closeInspectModal()">&times;</button>
        </div>

        <div class="inspect-modal-body">
            <!-- Katalog Preview -->
            <div class="katalog-preview">
                <div class="preview-header">
                    <img id="inspect-logo" src="" alt="" class="preview-logo">
                    <div class="preview-info">
                        <h2 id="inspect-company-name" class="preview-company-name"></h2>
                        <div>
                            <span id="inspect-business-field" class="preview-business-field"></span>
                            <span id="inspect-status" class="preview-status-badge pending">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Menunggu Verifikasi
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Alamat
                    </div>
                    <div id="inspect-address" class="detail-value"></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Telepon
                    </div>
                    <div id="inspect-phone" class="detail-value large"></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Email
                    </div>
                    <div id="inspect-email" class="detail-value"></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Website
                    </div>
                    <div id="inspect-website" class="detail-value"></div>
                </div>
            </div>

            <!-- Description -->
            <div class="description-section">
                <h4>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    Deskripsi Perusahaan
                </h4>
                <div id="inspect-description" class="description-text"></div>
            </div>

            <!-- Creator Info -->
            <div class="creator-section">
                <h4>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Dibuat Oleh Anggota
                </h4>
                <div class="creator-card">
                    <div id="inspect-creator-avatar" class="creator-avatar-large"></div>
                    <div class="creator-info-large">
                        <div id="inspect-creator-name" class="creator-name-large"></div>
                        <div id="inspect-creator-meta" class="creator-meta-large"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="inspect-modal-actions">
            <button type="button" onclick="closeInspectModal()" class="btn-inspect-close">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Tutup
            </button>
            
            <button type="button" id="btn-inspect-reject" onclick="rejectFromInspect()" class="btn-inspect-reject">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                Tolak Katalog
            </button>
            
            <form id="form-inspect-approve" method="POST" style="flex: 1; margin: 0;">
                @csrf
                <button type="submit" class="btn-inspect-approve" style="width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    Setujui Katalog
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let currentKatalogId = null;

function openInspectModal(katalogId, katalogData) {
    currentKatalogId = katalogId;
    
    // Populate modal dengan data
    document.getElementById('inspect-logo').src = katalogData.logo_url;
    document.getElementById('inspect-logo').alt = katalogData.company_name;
    document.getElementById('inspect-company-name').textContent = katalogData.company_name;
    document.getElementById('inspect-business-field').textContent = katalogData.business_field;
    document.getElementById('inspect-address').textContent = katalogData.address;
    document.getElementById('inspect-phone').textContent = katalogData.phone;
    document.getElementById('inspect-email').textContent = katalogData.email;
    document.getElementById('inspect-website').textContent = katalogData.website || '-';
    document.getElementById('inspect-description').textContent = katalogData.description || 'Tidak ada deskripsi';
    
    // Creator info
    if (katalogData.anggota) {
        const initials = katalogData.anggota.nama_usaha.substring(0, 2).toUpperCase();
        document.getElementById('inspect-creator-avatar').textContent = initials;
        document.getElementById('inspect-creator-name').textContent = katalogData.anggota.nama_usaha;
        document.getElementById('inspect-creator-meta').textContent = katalogData.anggota.domisili;
    }
    
    // Set form action
    document.getElementById('form-inspect-approve').action = `/admin/katalog/${katalogId}/approve`;
    
    // Show modal
    document.getElementById('inspectModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeInspectModal() {
    document.getElementById('inspectModal').classList.remove('show');
    document.body.style.overflow = '';
    currentKatalogId = null;
}

function rejectFromInspect() {
    closeInspectModal();
    // Tunggu sebentar agar transisi modal selesai
    setTimeout(() => {
        openRejectModal(currentKatalogId);
    }, 300);
}

// Close modal saat klik di luar
window.addEventListener('click', function(event) {
    const modal = document.getElementById('inspectModal');
    if (event.target === modal) {
        closeInspectModal();
    }
});

// Close modal dengan ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeInspectModal();
    }
});
</script>