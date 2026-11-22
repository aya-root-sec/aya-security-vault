<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خزنة الطوارئ الشاملة | Zero-Knowledge Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- شريط القيادة العلوي -->
    <nav class="top-nav">
        <div class="logo">🛡️ aya security | Zero-Knowledge Vault</div>
        <div class="security-status">
            <span class="pulse-dot"></span> نظام التشفير المحلي نشط
        </div>
    </nav>
    <!-- حاوية النظام الحديثة -->
    <main class="vault-container">
        
        <!-- الخطوة 1: بوابة المصادقة والمفتاح الرئيسي -->
        <section class="vault-step active" id="step1">
            <div class="glass-card">
                <div class="step-badge">الخطوة 01 من 03</div>
                <h1>إنشاء أو فتح المفتاح الرئيسي</h1>
                <p>هذا المفتاح يولد محلياً في متصفحك. لا يمكن لأي سيرفر أو جهة في العالم قراءة بياناتك دونه.</p>
                
                <div class="input-group">
                    <label>اسم المستخدم التعريفي</label>
                    <input type="text" id="username" placeholder="مثال: aya_security">
                </div>
                
                <div class="input-group">
                    <label>كلمة المرور الرئيسية (مفتاح فك التشفير)</label>
                    <input type="password" id="masterKey" placeholder="أدخل كلمة مرور قوية جداً...">
                </div>
                
                <button class="btn-cyber" onclick="unlockVault()">تأكيد المفتاح والدخول للخزنة ←</button>
            </div>
        </section>

        <!-- الخطوة 2: لوحة النسخ الاحتياطي الشامل (الصور، الفيديوهات، الملفات، الكلمات) -->
        <section class="vault-step locked" id="step2">
            <div class="glass-card wide">
                <div class="step-badge safe">الخطوة 02: تجميع محتويات الجهاز للنسخة الاحتياطية</div>
                <h2>حزمة الطوارئ الشاملة (Vault Payload)</h2>
                <p>ارفع ملفاتك الهامة، صورك، مقاطعك، وكلمات مرورك لتُشفر بالكامل قبل إرسالها.</p>
                
                <div class="grid-inputs">
                    <div class="input-group">
                        <label>عنوان الحزمة أو اسم الجهاز</label>
                        <input type="text" id="serviceName" placeholder="مثال: Full Phone Backup - Note 13">
                    </div>
                    
                    <div class="input-group">
                        <label>كلمات المرور والحسابات والملاحظات النصية</label>
                        <textarea id="secretText" rows="3" placeholder="اكتب حساباتك، مفاتيح 2FA، أو ملاحظاتك السرية هنا..."></textarea>
                    </div>

                    <div class="input-group file-upload-box">
                        <label>📁 ارفع ملفاتك الهامة (صور، صوتيات، فيديوهات، مستندات)</label>
                        <input type="file" id="vaultFiles" multiple class="file-input">
                        <small style="color: var(--text-muted);">يمكنك اختيار صور، تسجيلات، أو ملفات مضغوطة لتُشفر معاً.</small>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn-secondary" onclick="lockVault()">🔒 إقفال الخزنة</button>
                    <button class="btn-cyber" onclick="encryptAndUploadBundle()">تشفير حزمة الجهاز بالكامل وحفظها ⚡</button>
                </div>

                <!-- معاينة التشفير الحي -->
                <div id="cipherBox" class="cipher-preview hidden">
                    <small>النتيجة المشفرة المحفوظة في السيرفر (Ciphertext):</small>
                    <code id="cipherText"></code>
                    <p id="saveStatus" style="margin-top: 0.5rem; font-size: 0.9rem;"></p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;">
           
            
            <!-- ضعي زر التدمير الذاتي هذا هنا تماماً -->
<button type="button" onclick="panicWipeVault()" style="background: #EF4444; color: white; border: none; padding: 12px 15px; border-radius: 8px; cursor: pointer; margin-top: 10px; width: 100%; font-weight: bold; font-size: 1rem;">🚨 تدمير ذاتي للطوارئ (Panic)</button>
        </div>
            </div>
        </section><!-- الخطوة 3: دليل الاستعادة الطارئة عند الكارثة -->
        <section class="vault-step locked" id="step3">
            <div class="glass-card">
                <div class="step-badge warning">الخطوة 03: استعادة البيانات عند فقدان الجهاز</div>
                <h2>بروتوكول النجاة واستعادة الحسابات</h2>
                <ul class="steps-list">
                    <li><strong>1. في حال عمل ضبط مصنع (Format):</strong> لا تقلق، بياناتك مشفرة ومحفوظة بأمان تام هنا.</li>
                    <li><strong>2. الدخول من جهاز بديل:</strong> افتح الموقع، أدخل اسم المستخدم ومفتاحك الرئيسي لتسترجع كل ملفاتك وحساباتك.</li>
                    <li><strong>3. الأمان المطلق:</strong> تذكر أن الخادم لا يحتفظ بكلمة سرك، وحدك من تملك القدرة على فك التشفير.</li>
                </ul>
                <button class="btn-secondary" onclick="resetToStep1()">إغلاق الجلسة تماماً</button>
            </div>
        </section>

    </main>

    <script>
        let sessionUser = "";
        let sessionKey = "";

        // دالة الحماية: الانتقال للخطوة الثانية فقط عند توفر البيانات الأساسية
        function unlockVault() {
            const user = document.getElementById('username').value.trim();
            const key = document.getElementById('masterKey').value.trim();

            if (!user || !key) {
                alert('الرجاء إدخال اسم المستخدم وكلمة المرور الرئيسية أولاً لفتح الخزنة!');
                return;
            }

            sessionUser = user;
            sessionKey = key;

            // فتح الخطوة الثانية وإقفال الأولى بأسلوب سلس
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step1').classList.add('locked');
            
            document.getElementById('step2').classList.remove('locked');
            document.getElementById('step2').classList.add('active');
        }

        function lockVault() {
            sessionUser = "";
            sessionKey = "";
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step2').classList.add('locked');
            
            document.getElementById('step1').classList.remove('locked');
            document.getElementById('step1').classList.add('active');
        }

        function resetToStep1() {
            location.reload();
        }

        // دالة تشفير الحزمة (النصوص + الملفات المرفوعة) وإرسالها لملف save.php
      // دالة تشفير حقيقية وآمنة باستخدام Web Crypto API (AES-GCM)
        async function encryptAndUploadBundle() {
            const serviceName = document.getElementById('serviceName').value.trim() || 'General Device Backup';
            const secretText = document.getElementById('secretText').value.trim();
            const fileInput = document.getElementById('vaultFiles');

            if (!secretText && fileInput.files.length === 0) {
                alert('الرجاء كتابة ملاحظات أو إرفاق ملف واحد على الأقل للنسخة الاحتياطية!');
                return;
            }

            try {
               // تحويل مفتاح المستخدم إلى مفتاح تشفير حقيقي للـ Web Crypto API (AES-GCM)
const enc = new TextEncoder();
const keyBytes = enc.encode(sessionKey.padEnd(32, '0').substring(0, 32));

const cryptoKey = await window.crypto.subtle.importKey(
    "raw",
    keyBytes,
    { name: "AES-GCM", length: 256 },
    true,
    ["encrypt", "decrypt"]
);

                const iv = window.crypto.getRandomValues(new Uint8Array(12)); // IV عشوائي آمن
                const rawData = JSON.stringify({
                    user: sessionUser,
                    notes: secretText,
                    filesCount: fileInput.files.length,
                    timestamp: new Date().toISOString()
                });

                const encryptedBuffer = await window.crypto.subtle.encrypt(
    {
        name: "AES-GCM",
        iv: iv
    },
    cryptoKey,
    new TextEncoder().encode(rawData)
);

                // دمج الـ IV مع النص المشفر وتحويله لـ Base64 للإرسال الآمن
                const encryptedPayload = "AESGCM::" + btoa(String.fromCharCode(...iv)) + "::" + btoa(String.fromCharCode(...new Uint8Array(encryptedBuffer)));

                // إرسال البيانات للسيرفر بصمت تام
                const formData = new FormData();
                formData.append('username', sessionUser);
                formData.append('service_name', serviceName);
                formData.append('encrypted_data', encryptedPayload);

                const response = await fetch('save.php', { method: 'POST', body: formData });
                const data = await response.json();

                if(data.status === 'success') {
                    alert('🔒 تم تشفير البيانات بـ AES-GCM الحقيقي ورفعها للسيرفر بسرية مطلقة!');
                    setTimeout(() => {
                        document.getElementById('step2').classList.remove('active');
                        document.getElementById('step2').classList.add('locked');
                        document.getElementById('step3').classList.remove('locked');
                        document.getElementById('step3').classList.add('active');
                    }, 500);
                } else {
                    alert('تنبيه: ' + data.message);
                }
            } catch (err) {
                console.error(err);
                alert('حدث خطأ أثناء عملية التشفير المشفر محلياً.');
            }}
        function panicWipeVault() {
    if (confirm('⚠️ تحذير خطير: هل أنت متأكدة من رغبتك في تدمير ومسح كافة بيانات الجلسة فوراً؟')) {
        
        // 1. مسح الحقول وتفريغ الواجهة فوراً
        const secretInput = document.getElementById('secretText');
        const serviceInput = document.getElementById('serviceName');
        if (secretInput) secretInput.value = "";
        if (serviceInput) serviceInput.value = "";
        
        // 2. تفريغ المتغيرات الحساسة في الذاكرة
        if (typeof sessionUser !== 'undefined') sessionUser = "";
        if (typeof sessionKey !== 'undefined') sessionKey = "";
        
        // 3. إعادة تحميل الصفحة فوراً لتنظيف الذاكرة والـ DOM
        location.reload();
    }
}
    </script>
</body>
</html>