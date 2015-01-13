<?php
/* @var $this yii\web\View */
$this->title = 'Nikolay Kovenko - Curriculum Vitae';
?>

<? foreach ($this->context->categories as $category): ?>
	<section class="main-section">
		<h2 class="main-section-h" id="<?= $category->static ?>"><?= $category->caption ?></h2>
		<? if ($category->skills_matrix): ?>
			<div class="row">
				<div class="col-lg-6 col-lg-push-6">
					<dl>
						<?php foreach ($category->parameterValues as $parameter): ?>
						<?php if ($parameter->in_new_column): ?>
					        </dl></div><div class="col-lg-6 col-lg-pull-6"><dl>
						<?php endif ?>

						<dt><?= $parameter->caption ?></dt>
						<dd>
							<?php if (!empty($parameter->skills)): ?>
								<table class="table table-condensed table-hover table-skills">
									<thead>
									<tr>
										<th>Item</th>
										<th class="years">No. of years</th>
										<th class="skill">Skill level</th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($parameter->skills as $skill): ?>
										<tr>
											<td><?= $skill->caption ?></td>
											<td><?= $skill->years ?></td>
											<td><?= $skill->level ?></td>
										</tr>
									<?php endforeach ?>
									</tbody>
								</table>
							<?php endif ?>
						</dd>
						<?php endforeach ?>
					</dl>
				</div>
			</div>
			<aside class="note">
				<p>* Skill level: 1 – Theoretical knowledge; 2 - Junior; 3 – Confirmed experience; 4 – Advanced experienced; 5 – Senior expert.</p>
			</aside>
		<? else: ?>
			<dl>
				<? foreach ($category->parameterValues as $param): ?>
					<dt><?= $param->caption ?></dt>
					<dd><p><?= $param->value ?></p></dd>
				<? endforeach ?>
			</dl>
		<? endif; ?>
		
	</section>
<? endforeach; ?>