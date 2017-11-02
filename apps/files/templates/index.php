<?php /** @var $l \OCP\IL10N */ ?>
<?php $_['appNavigation']->printPage(); ?>
<!---->
<!--	<script src="https://ctj.clarin-pl.eu/clarin_bar/script.js"></script>-->
<!--	<script nonce="--><?php //p(\OC::$server->getContentSecurityPolicyNonceManager()->getNonce()) ?><!--" type="text/javascript">-->
<!--		window.onload = function() {-->
<!--			new ClarinModule({-->
<!--				offset:{-->
<!--					'top': '0',-->
<!--					'right': null,-->
<!--					'bottom': null,-->
<!--					'left': '10',-->
<!--				},-->
<!--				arrow:{-->
<!--					'initial-orientation': "top",// 'up' || 'down' || 'right' || 'left'-->
<!--					'rotation-hover': 90,-->
<!--				},-->
<!--				themeColor: '#337ab7',-->
<!--				horizontal: true // false || true-->
<!--			});-->
<!--			c.hookFunctionTo('logout', function(){-->
<!---->
<!--				$.get('--><?php //print_unescaped(\OC_User::getLogoutAttribute()); ?>//'.replace('href="','').replace('"',''));
<!--//			});-->
<!--//		};-->
<!--//-->
<!--//	</script>-->


<div id="app-content">
	<?php foreach ($_['appContents'] as $content) { ?>
	<div id="app-content-<?php p($content['id']) ?>" class="hidden viewcontainer">
	<?php print_unescaped($content['content']) ?>
	</div>
	<?php } ?>
	<div id="searchresults" class="hidden"></div>
</div><!-- closing app-content -->

<!-- config hints for javascript -->
<input type="hidden" name="filesApp" id="filesApp" value="1" />
<input type="hidden" name="usedSpacePercent" id="usedSpacePercent" value="<?php p($_['usedSpacePercent']); ?>" />
<input type="hidden" name="owner" id="owner" value="<?php p($_['owner']); ?>" />
<input type="hidden" name="ownerDisplayName" id="ownerDisplayName" value="<?php p($_['ownerDisplayName']); ?>" />
<input type="hidden" name="fileNotFound" id="fileNotFound" value="<?php p($_['fileNotFound']); ?>" />
<?php if (!$_['isPublic']) :?>
<input type="hidden" name="allowShareWithLink" id="allowShareWithLink" value="<?php p($_['allowShareWithLink']) ?>" />
<input type="hidden" name="defaultFileSorting" id="defaultFileSorting" value="<?php p($_['defaultFileSorting']) ?>" />
<input type="hidden" name="defaultFileSortingDirection" id="defaultFileSortingDirection" value="<?php p($_['defaultFileSortingDirection']) ?>" />
<input type="hidden" name="showHiddenFiles" id="showHiddenFiles" value="<?php p($_['showHiddenFiles']); ?>" />
<?php endif;
