<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignation Responsable de Club - Orient'Action</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 40px 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
        .content { padding: 40px 30px; text-align: center; }
        .greeting { font-size: 20px; font-weight: 500; color: #2d3748; margin-bottom: 10px; }
        .button { display: inline-block; background: #48bb78; color: white; padding: 16px 40px; font-size: 16px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 30px 0; box-shadow: 0 4px 15px rgba(72,187,120,0.3); transition: all 0.2s; }
        .button:hover { background: #38a169; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(72,187,120,0.4); }
        .url-text { font-family: 'Courier New', monospace; word-break: break-all; color: #666; font-size: 14px; padding: 15px; background: #f7fafc; border-radius: 6px; margin: 20px 0; }
        .footer { background: #f8f9fa; padding: 30px; text-align: center; font-size: 14px; color: #718096; border-top: 1px solid #e2e8f0; }
        .footer a { color: #48bb78; text-decoration: none; }
        @media (max-width: 600px) { .container { margin: 10px; } .header, .content { padding-left: 20px; padding-right: 20px; } }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>👋 Bienvenue !</h1>
    </div>

    <div class="content">
        <p class="greeting">Félicitations {{ $fullName }},</p>

        <p style="font-size: 16px; color: #4a5568; margin-bottom: 30px;">
            Vous avez été assigné(e) comme responsable du club :
        </p>
        <h3>{{ $clubName }}</h3>

        <p>Aucune action n'est requise de votre part. Vous pouvez dès maintenant gérer votre club.</p>
        <p>Cordialement,<br>L'équipe Orient'Action</p>
    </div>

    <div class="footer">
        <p><strong>Orient'Action</strong> - L'aventure sportive commence ici !</p>
        <p><a href="#">www.orientaction.com</a> | <a href="#">Contact</a></p>
    </div>
</div>
</body>
</html>
