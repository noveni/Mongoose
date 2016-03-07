<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading"><i class="icon-cogs">Feed the feed</i></div>
			<div class="panel-content">
				<p>{l s='Pour ajouter les produis d'un fournisseur, cliquer sur le bouton ce-dessous.' mod='mongoose'}</p>
				<form action="{$link->getAdminLink('AdminMongooseImport',true)}" method="post" id="step0form">
					<button type="submit" class="btn btn-default btn-md" id="step0from_start">{l s='Cliquez ici.'}</button>
					<input type="hidden" id="submitStep0Mongoose" name="submitStep0Mongoose" value="1">
				</form>
			</div>
		</div>
	</div>
</div>