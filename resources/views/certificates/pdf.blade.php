<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate: {{ $certificate->certificate_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .certificate {
            position: relative;
            width: 100%;
            padding: 40px;
            box-sizing: border-box;
            border: 20px solid #6366f1;
            border-radius: 10px;
            background-color: #f9fafb;
            text-align: center;
        }
        .certificate-inner {
            border: 2px solid #a5b4fc;
            padding: 40px;
            border-radius: 5px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .logo {
            text-align: left;
        }
        .certificate-id {
            text-align: right;
            font-size: 12px;
            color: #666;
        }
        .title {
            font-size: 36px;
            color: #4f46e5;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }
        .recipient {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            color: #333;
        }
        .course-title {
            font-size: 22px;
            font-weight: bold;
            margin: 20px 0;
            color: #4f46e5;
        }
        .description {
            font-size: 14px;
            margin: 20px 0 40px;
            color: #666;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .date {
            text-align: left;
            font-size: 14px;
        }
        .signature {
            text-align: right;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(99, 102, 241, 0.05);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="watermark">VERIFIED</div>
        <div class="certificate-inner">
            <div class="header">
                <div class="logo">
                    <strong>E-Learning Platform</strong>
                </div>
                <div class="certificate-id">
                    <p>ID: {{ $certificate->certificate_number }}</p>
                </div>
            </div>
            
            <div class="title">Sertifikat Penyelesaian</div>
            <div class="subtitle">dengan bangga menyatakan bahwa</div>
            
            <div class="recipient">{{ $certificate->user->name }}</div>
            <div class="subtitle">telah berhasil menyelesaikan</div>
            
            <div class="course-title">
                @if($certificate->course)
                    {{ $certificate->course->title }}
                @elseif($certificate->learningPath)
                    Jalur Pembelajaran: {{ $certificate->learningPath->title }}
                @endif
            </div>
            
            <div class="description">{{ $certificate->description }}</div>
            
            <div class="footer">
                <div class="date">
                    <p>Tanggal Diterbitkan</p>
                    <p><strong>{{ $certificate->issued_at->format('d F Y') }}</strong></p>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <p><strong>Platform Admin</strong></p>
                    <p>E-Learning Platform</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 