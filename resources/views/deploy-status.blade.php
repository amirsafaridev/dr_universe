<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وضعیت Deployment</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .status-card {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }
        .status-indicator {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .status-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }
        .deploy-time {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .log-container {
            background: #1e1e1e;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.6;
            max-height: 500px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .actions {
            padding: 30px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }
        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            color: white;
        }
        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #e0a800);
            color: #212529;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .refresh-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2196f3;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 وضعیت Deployment</h1>
            <p>DeployFixServiceProvider Status</p>
        </div>
        
        <div class="status-card">
            <h2>وضعیت فعلی:</h2>
            @if($isDeployed)
                <div class="status-indicator status-success">
                    ✅ Deployment تکمیل شده است
                </div>
                <div class="deploy-time">
                    <strong>زمان تکمیل:</strong> {{ $deployTime }}
                </div>
            @else
                <div class="status-indicator status-pending">
                    ⏳ Deployment در انتظار اجرا
                </div>
                <div class="refresh-info">
                    <strong>نکته:</strong> برای اجرای deployment، صفحه را refresh کنید یا دوباره به سایت مراجعه کنید.
                </div>
            @endif
        </div>
        
        @if($logContent)
        <div class="status-card">
            <h2>📋 لاگ Deployment:</h2>
            <div class="log-container">{{ $logContent }}</div>
        </div>
        @endif
        
        <div class="actions">
            <a href="{{ url('/deploy-status') }}" class="btn btn-primary">🔄 Refresh</a>
            <a href="{{ url('/deploy-status/force-run') }}" class="btn btn-warning" onclick="return confirm('آیا مطمئن هستید که می‌خواهید deployment را دوباره اجرا کنید؟')">🔄 اجرای مجدد</a>
            <a href="{{ url('/') }}" class="btn btn-success">🏠 بازگشت به سایت</a>
        </div>
    </div>
    
    <script>
        // Auto refresh every 30 seconds if deployment is not done
        @if(!$isDeployed)
        setTimeout(function() {
            location.reload();
        }, 30000);
        @endif
    </script>
</body>
</html>
