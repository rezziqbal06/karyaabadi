<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<title>Reset Password Kamu</title>
	<!--[if mso]>
	  <noscript>
	    <xml>
	      <o:OfficeDocumentSettings>
	        <o:PixelsPerInch>96</o:PixelsPerInch>
	      </o:OfficeDocumentSettings>
	    </xml>
	  </noscript>
	  <![endif]-->
	<link rel="stylesheet" type="text/css" href="https://cdn.thecloudalert.com/assets/css/email.min.css" />

</head>

<body bgcolor="#bebebe">
	<!-- HEADER -->

	<!-- /HEADER -->

	<!-- BODY -->
	<table class="body-wrap" summary="body content" style="background-position: center center; background-repeat: repeat-y; background-size: contain; margin-top:16px; ">
		<tr>
			<td>&nbsp;</td>
			<td class="container" bgcolor="#FFFFFF" style="border-radius:6px;">
				<div class="content">
					<table style="width: 100%;">
						<tr>
							<td style="text-align: center;">
								<h1><b>Permintaan Reset Password</b></h1>
								<br />
								<br />
								<h3><b>Halo {{fnama}},</b></h3>
								<p class="lead">
									Kami telah menerima permintaan untuk reset password akun {{app_name}}.
									Buka link dibawah ini untuk mereset password.
								</p>
								<p>&nbsp;</p>
								<p style="text-align: center;">
									<a href="{{reset_link}}" style="background-color: #121212; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block;font-size: 16px;border-radius:4px;">Reset Password!</a>
								</p>
								<br />
								<p class="callout">
									Apabila link tidak bisa diklik, silakan copy-paste link tersebut dan langsung buka linknya di browser.
									<br />
								</p>
								<br />
								<br />
								<p><b>Abaikan email ini jika kamu tidak pernah meminta untuk reset password. Untuk pertanyaan, silakan hubungi <a href="mailto:{{cs_email}}">{{cs_email}}</a>.</p>
								<br />
								<br />
								<p>Best Regards,</p>
								<p>{{company_name}}</p>
								<br />
								<br />
								<br />
								<hr>
								<p style="color: #3c3c3c; font-size: smaller"><em>Apabila link tidak bisa diklik / dibuka, silakan <b>Copy</b> <b>Paste</b> langsung di browser anda.</em></p>
								<p style="color: #3c3c3c; font-size: smaller"><em>Supaya tidak masuk ke spam, silakan tambahkan email: {{email_dari}} ini ke kontak anda.</em></p>
							</td>
						</tr>
					</table>
					<p style="text-align: center; font-size: small; color: #3c3c3c; font-style: italic;">Copyright © {{site_name}}, All rights reserved.</p>
				</div><!-- /content -->
			</td>
			<td>&nbsp;</td>
		</tr>
	</table><!-- /BODY -->

	<!-- FOOTER -->
	{{content_footer}}
	<!-- /FOOTER -->

</body>

</html>