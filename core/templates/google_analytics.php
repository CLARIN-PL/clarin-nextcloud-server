<?php

// Global site tag (gtag.js) - Google Analytics -->
echo '
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-61350840-9"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag(\'js\', new Date());

			gtag(\'config\', \'UA-61350840-9\');
		</script>
';