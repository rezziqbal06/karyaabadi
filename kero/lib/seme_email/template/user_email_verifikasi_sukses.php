<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width,initial-scale=1">
	  <meta name="x-apple-disable-message-reformatting">
		<title>Terimakasih</title>
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

	<body bgcolor="#FFFFFF">
		<!-- HEADER -->
		{{content_header}}
		<!-- /HEADER -->

		<!-- BODY -->
		<table class="body-wrap" summary="body content" style="background-position: center center; background-repeat: repeat-y; background-image: url('https://karirsbp-prod.b-cdn.net/media/email-background-main.png'); background-size: contain;">
			<tr>
				<td>&nbsp;</td>
				<td class="container" bgcolor="#FFFFFF">
					<div class="content">
						<table>
							<tr>
								<td style="text-align: center;">
									<h1><b>Email berhasil diverifikasi</b></h1>
									<br />
									<br />
									<h3><b>Halo {{fnama}},</b></h3>
									<p class="lead">
										Email ini sudah berhasil diverifikasi, sekarang kamu bisa melanjutkan tahap selanjutnya di {{app_name}}.
									</p>
									<br />
                  <p><b>Apabila ada pertanyaan, silakan hubungi <a href="mailto:{{cs_email}}">{{cs_email}}</a>.</p>
									<br />
									<br />
                  <p>Salam,</p>
                  <p>{{site_name}} team</p>
								</td>
							</tr>
						</table>
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
