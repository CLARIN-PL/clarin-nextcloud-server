<?php

echo '
		<script nonce="'. \OC::$server->getContentSecurityPolicyNonceManager()->getNonce() .'" async src="https://www.googletagmanager.com/gtag/js?id=UA-61350840-9"></script>
		<script nonce="'. \OC::$server->getContentSecurityPolicyNonceManager()->getNonce() .'" >
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag(\'js\', new Date());

			gtag(\'config\', \'UA-61350840-9\');
		</script>
';