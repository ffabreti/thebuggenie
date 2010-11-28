<?php

	include_template('publish/wikibreadcrumbs', array('article_name' => $article_name));
	TBGContext::loadLibrary('publish/publish');
	$tbg_response->setTitle(__('%article_name% permissions', array('%article_name%' => $article_name)));

?>
<table style="margin-top: 0px; table-layout: fixed; width: 100%" cellpadding=0 cellspacing=0>
	<tr>
		<td class="side_bar">
			<?php include_component('leftmenu', array('article' => $article)); ?>
		</td>
		<td class="main_area article">
			<a name="top"></a>
			<div class="article" style="width: auto; padding: 5px; position: relative;">
				<div class="header tab_menu">
					<ul class="right">
						<li><?php echo link_tag(make_url('publish_article', array('article_name' => $article->getName())), __('Show')); ?></li>
						<?php if (TBGContext::getModule('publish')->canUserEditArticle($article->getName())): ?>
							<li><?php echo link_tag(make_url('publish_article_edit', array('article_name' => $article->getName())), __('Edit')); ?></li>
						<?php endif; ?>
						<li><?php echo link_tag(make_url('publish_article_history', array('article_name' => $article->getName())), __('History')); ?></li>
						<li class="selected"><?php echo link_tag(make_url('publish_article_permissions', array('article_name' => $article->getName())), __('Permissions')); ?></li>
					</ul>
					<?php if (TBGContext::isProjectContext()): ?>
						<?php if ((strpos($article->getName(), ucfirst(TBGContext::getCurrentProject()->getKey())) == 0) || ($article->isCategory() && strpos($article->getName(), ucfirst(TBGContext::getCurrentProject()->getKey())) == 9)): ?>
							<?php $project_article_name = substr($article->getName(), ($article->isCategory() * 9) + strlen(TBGContext::getCurrentProject()->getKey())+1); ?>
							<?php if ($article->isCategory()): ?><span class="faded_out blue">Category:</span><?php endif; ?><span class="faded_out dark"><?php echo ucfirst(TBGContext::getCurrentProject()->getKey()); ?>:</span><?php echo get_spaced_name($project_article_name); ?>
						<?php endif; ?>
					<?php elseif (substr($article->getName(), 0, 9) == 'Category:'): ?>
						<span class="faded_out blue">Category:</span><?php echo get_spaced_name(substr($article->getName(), 9)); ?>
					<?php else: ?>
						<?php echo get_spaced_name($article->getName()); ?>
					<?php endif; ?>
					<span class="faded_out"><?php echo __('%article_name% ~ Permissions', array('%article_name%' => '')); ?></span>
				</div>
				<form action="">
					<ul class="simple_list">
					<?php foreach ($article->getCombinedNamespaces() as $namespace): ?>
						<li onclick="">
							<div class="namespace_header">
								<?php echo __('Specify permissions for the %namespace% namespace', array('%namespace%' => '<span class="namespace">'.$namespace.'</span>')); ?>
							</div>
							<?php echo __('Select this option to specify permissions for the above namespace. These permissions will apply for all articles in the mentioned namespace for which article-specific permissions have not been granted.'); ?>
							<div id="publish_<?php echo $namespace; ?>_permissions">
								<?php include_component('configuration/permissionsinfo', array('key' => 'editarticle', 'mode' => 'module_permissions', 'target_id' => $namespace, 'module' => 'publish', 'access_level' => TBGSettings::ACCESS_FULL)); ?>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
				</form>
			</div>
		</td>
	</tr>
</table>