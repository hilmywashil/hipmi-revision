@extends('layouts.app')

@section('title', 'Registrasi Berhasil - HIPMI Jawa Barat')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #04293b 0%, #052e44 50%, #06374d 100%);
        min-height: 100vh;
    }

    .success-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .success-container {
        max-width: 680px;
        width: 100%;
        position: relative;
    }

    .success-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 3.5rem 3rem;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #04293b 0%, #052e44 100%);
    }

    .success-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .success-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #04293b 0%, #052e44 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
        box-shadow: 0 10px 30px rgba(4, 41, 59, 0.4);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .success-icon::after {
        content: '';
        position: absolute;
        width: 110px;
        height: 110px;
        border: 2px solid rgba(4, 41, 59, 0.3);
        border-radius: 50%;
        animation: pulse 2s ease-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.3;
        }
        50% {
            transform: scale(1.1);
            opacity: 0;
        }
    }

    .success-icon svg {
        width: 48px;
        height: 48px;
        stroke: white;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .success-header h1 {
        font-size: 2rem;
        font-weight: 800;
        color: #0f1419;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }

    .success-header p {
        color: #5a6c7d;
        font-size: 1.0625rem;
        line-height: 1.6;
        font-weight: 500;
    }

    .credentials-section {
        background: linear-gradient(135deg, #04293b 0%, #052e44 100%);
        border-radius: 16px;
        padding: 2rem;
        margin: 2rem 0;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(4, 41, 59, 0.3);
    }

    .credentials-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .credentials-section h3 {
        font-size: 1.125rem;
        margin: 0 0 1.5rem 0;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        position: relative;
        z-index: 1;
    }

    .credential-item {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .credential-item:hover {
        background: rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
    }

    .credential-item:last-of-type {
        margin-bottom: 0;
    }

    .credential-label {
        font-size: 0.8125rem;
        opacity: 0.95;
        margin-bottom: 0.625rem;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .credential-value {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: white;
        padding: 1rem 1.25rem;
        border-radius: 10px;
    }

    .credential-text {
        font-family: 'SF Mono', 'Monaco', 'Consolas', monospace;
        font-size: 1.0625rem;
        font-weight: 600;
        word-break: break-all;
        flex: 1;
        color: #0f1419;
    }

    .btn-copy-small {
        background: #04293b;
        color: white;
        border: none;
        padding: 0.5rem 1.125rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(4, 41, 59, 0.4);
    }

    .btn-copy-small:hover {
        background: #052e44;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(4, 41, 59, 0.5);
    }

    .btn-copy-small:active {
        transform: translateY(0);
    }

    .copy-success {
        background: #10b981 !important;
        animation: successPulse 0.4s ease;
    }

    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .download-section {
        margin: 2rem 0;
        padding: 2rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #bae6fd;
        border-radius: 16px;
        text-align: center;
    }

    .download-section h4 {
        color: #0c4a6e;
        font-size: 1.0625rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        justify-content: center;
    }

    .download-section p {
        color: #0369a1;
        margin-bottom: 1.25rem;
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .btn-download {
        background: linear-gradient(135deg, #04293b 0%, #052e44 100%);
        color: white;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.9375rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(4, 41, 59, 0.4);
    }

    .btn-download:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(4, 41, 59, 0.5);
    }

    .important-notes {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #fbbf24;
        border-radius: 16px;
        padding: 1.75rem;
        margin: 1.5rem 0;
        text-align: left;
    }

    .important-notes h4 {
        color: #92400e;
        font-size: 1.0625rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .important-notes ul {
        margin: 0;
        padding-left: 1.25rem;
        color: #78350f;
    }

    .important-notes li {
        margin-bottom: 0.625rem;
        line-height: 1.6;
        font-weight: 500;
    }

    .important-notes li:last-child {
        margin-bottom: 0;
    }

    .important-notes strong {
        color: #92400e;
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn span {
        position: relative;
        z-index: 1;
    }

    .btn svg {
        position: relative;
        z-index: 1;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #04293b 0%, #052e44 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(4, 41, 59, 0.4);
    }

    .btn-primary:hover {
        box-shadow: 0 10px 30px rgba(4, 41, 59, 0.5);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    @media (max-width: 640px) {
        .success-card {
            padding: 2.5rem 1.75rem;
        }

        .success-header h1 {
            font-size: 1.625rem;
        }

        .credential-value {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-copy-small {
            width: 100%;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="success-wrapper">
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>

                <h1>Registrasi Berhasil!</h1>
                <p>Selamat datang di HIPMI Jawa Barat. Akun Anda telah berhasil dibuat dan sedang dalam proses verifikasi oleh admin.</p>
            </div>

            <div class="credentials-section">
                <h3>
                    <span>Kredensial Login Anda</span>
                </h3>
                
                <div class="credential-item">
                    <div class="credential-label">Email Login</div>
                    <div class="credential-value">
                        <span class="credential-text" id="emailText">{{ session('user_email') }}</span>
                        <button class="btn-copy-small" onclick="copyText('emailText', this)">Copy</button>
                    </div>
                </div>

                <div class="credential-item">
                    <div class="credential-label">Password</div>
                    <div class="credential-value">
                        <span class="credential-text" id="passwordText">{{ session('generated_password') }}</span>
                        <button class="btn-copy-small" onclick="copyText('passwordText', this)">Copy</button>
                    </div>
                </div>
            </div>

            <div class="download-section">
                <h4>
                    <span>Download Kredensial Anda</span>
                </h4>
                <p>Simpan kredensial Anda dalam format yang mudah diakses</p>
                <button class="btn-download" onclick="downloadAsTXT()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span>Download TXT</span>
                </button>
            </div>

            <div class="important-notes">
                <h4>Catatan Penting</h4>
                <ul>
                    <li><strong>Simpan kredensial ini di tempat yang aman</strong> (notes, password manager, dll)</li>
                    <li>Gunakan email dan password ini untuk <strong>login</strong> setelah akun Anda disetujui admin</li>
                    <li>Anda dapat <strong>mengubah password</strong> kapan saja setelah login</li>
                    <li><strong>Jangan bagikan</strong> kredensial Anda kepada siapapun</li>
                    <li>Status verifikasi akan dikirim ke email Anda</li>
                </ul>
            </div>

            <div class="action-buttons">
                <a href="{{ route('profile-anggota') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <span>Lihat Profile Saya</span>
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    let credentialsSaved = false;
    let emailCopied = false;
    let passwordCopied = false;

    function copyText(elementId, button) {
        const text = document.getElementById(elementId).textContent;
        const originalText = button.textContent;
        
        if (elementId === 'emailText') emailCopied = true;
        if (elementId === 'passwordText') passwordCopied = true;
        
        if (emailCopied && passwordCopied) credentialsSaved = true;
        
        navigator.clipboard.writeText(text).then(() => {
            button.classList.add('copy-success');
            button.textContent = '✓ Copied!';
            
            setTimeout(() => {
                button.classList.remove('copy-success');
                button.textContent = originalText;
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin. Silakan copy manual.');
        });
    }

    function downloadAsTXT() {
        credentialsSaved = true;
        const email = document.getElementById('emailText').textContent;
        const password = document.getElementById('passwordText').textContent;
        const date = new Date().toLocaleString('id-ID', { 
            dateStyle: 'full', 
            timeStyle: 'short',
            timeZone: 'Asia/Jakarta'
        });
        
        const content = `
═══════════════════════════════════════════════════════
        HIPMI JAWA BARAT - KREDENSIAL LOGIN
═══════════════════════════════════════════════════════

Email Login    : ${email}
Password       : ${password}

═══════════════════════════════════════════════════════
                PERINGATAN KEAMANAN
═══════════════════════════════════════════════════════

⚠️ PENTING:
• Simpan file ini di tempat yang aman
• JANGAN bagikan kredensial kepada siapapun
• Ganti password setelah login pertama kali
• Hubungi admin jika lupa password

═══════════════════════════════════════════════════════

📅 Dokumen digenerate pada: ${date}
🌐 Website: www.hipmijawabarat.com
📧 Email: info@hipmijawabarat.com

═══════════════════════════════════════════════════════
        Terima kasih telah bergabung dengan HIPMI!
═══════════════════════════════════════════════════════
`.trim();

        const blob = new Blob([content], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'HIPMI_Kredensial_Login.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    window.addEventListener('beforeunload', function (e) {
        if (!credentialsSaved) {
            e.preventDefault();
            e.returnValue = 'Kredensial belum di-download atau di-copy! Apakah Anda yakin ingin meninggalkan halaman ini?';
        }
    });
</script>
@endsection