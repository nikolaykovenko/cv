<?php
/** @var $this SiteController */
/** @var $categories array */
?>

<?php foreach ($categories as $category): ?>
 <section class="main-section">
  <h2 class="main-section-h" id="<?= $category['static'] ?>"><?= $category['caption'] ?></h2>
  <dl>
   <?php foreach ($category->parameterValues as $parameter): ?>
	<dt><?= $parameter['caption'] ?></dt>
	<dd>
	 <?= !empty($parameter['value']) ? '<p>'.$parameter['value'].'</p>' : ''; ?>
	 <?php if (!empty($parameter['skills'])): ?>
	 <table class="table table-condensed table-hover table-skills">
	  <thead>
	  <tr>
	   <th>Item</th>
	   <th class="years">No. of years</th>
	   <th class="skill">Skill level</th>
	  </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($parameter['skills'] as $skill): ?>
	   <tr>
		<td><?= $skill['caption']; ?></td>
		<td><?= $skill['years']; ?></td>
		<td><?= $skill['level']; ?></td>
	   </tr>
	  <?php endforeach ?>
	  </tbody>
	  </table>
	 <?php endif ?>
	</dd>
   <?php endforeach ?>
  </dl>
 </section>
<?php endforeach; ?>

<!--
<section class="main-section">
 <h2 class="main-section-h" id="skills">Skills matrix</h2>
 <div class="row">
  <div class="col-lg-6 col-lg-push-6">
   <dl>
	<dt>Foreign languages</dt>
	<dd>
	 <table class="table table-condensed table-hover table-skills">
	  <thead>
	  <th>Item</th>
	  <th class="years">No. of years</th>
	  <th class="skill">Skill level</th>
	  </thead>
	  <tbody>
	  <tr>
	   <td><span data-toggle="tooltip" data-placement="top" title="Writting and reading level">English</span></td>
	   <td>6</td>
	   <td>2/3</td>
	  </tr>
	  <tr>
	   <td>Russian</td>
	   <td>19</td>
	   <td>4</td>
	  </tr>
	  <tr>
	   <td>Ukraine</td>
	   <td>22</td>
	   <td>4</td>
	  </tr>
	  </tbody>
	 </table>
	</dd>

	<dt>Systems [OS]</dt>
	<dd>
	 <table class="table table-condensed table-hover table-skills">
	  <tbody>
	  <tr>
	   <td>Windows</td>
	   <td class="years">13</td>
	   <td class="skill">4</td>
	  </tr>
	  <tr>
	   <td>Linux</td>
	   <td>5</td>
	   <td>2</td>
	  </tr>
	  <tr>
	   <td>Mac OS X</td>
	   <td>1</td>
	   <td>2</td>
	  </tr>
	  </tbody>
	 </table>
	</dd>
	<dt>Programming languages</dt>
	<dd>
	 <table class="table table-condensed table-hover table-skills">
	  <tbody>
	  <tr>
	   <td><span data-toggle="tooltip" data-placement="top" title="Experience in development such systems as: Internet portals, markets, catalogs, booking hotel rooms systems, virtual university, parsing tools, etc">PHP</span></td>
	   <td class="years">6</td>
	   <td class="skill">4</td>
	  </tr>
	  <tr>
	   <td><span data-toggle="tooltip" data-placement="top" title="Jquery experience">Javascript</span></td>
	   <td>4</td>
	   <td>3</td>
	  </tr>
	  </tbody>
	 </table>
	</dd>

	<dt>Database</dt>
	<dd>
	 <table class="table table-condensed table-hover table-skills">
	  <tbody>
	  <tr>
	   <td>MySQL</td>
	   <td class="years">6</td>
	   <td class="skill">4</td>
	  </tr>
	  </tbody>
	 </table>
	</dd>

   </dl>
  </div>
  <div class="col-lg-6 col-lg-pull-6">
   <dl>
	<dt>Tools/methods/other</dt>
	<dd>
	 <table class="table table-condensed table-hover table-skills">
	  <thead class="hidden-xs hidden-sm hidden-md">
	  <tr>
	   <th>Item</th>
	   <th class="years">No. of years</th>
	   <th class="skill">Skill level</th>
	  </tr>
	  </thead>
	  <tbody>
	  <tr>
	   <td>HTML</td><td class="years">11</td><td class="skill">4</td>
	  </tr>
	  <tr>
	   <td>CSS</td><td>6</td><td>4</td>
	  </tr>
	  <tr>
	   <td>Ajax</td><td>3</td><td>3</td>
	  </tr>
	  <tr>
	   <td>XML</td><td>3</td><td>3</td>
	  </tr>
	  <tr>
	   <td>JSON</td><td>3</td><td>3</td>
	  </tr>
	  <tr>
	   <td>UML</td><td>1</td><td>2</td>
	  </tr>
	  <tr>
	   <td>OOP/Design Patterns</td><td>1</td><td>2/3</td>
	  </tr>
	  <tr>
	   <td>HTML5, CSS3</td><td>3</td><td>3</td>
	  </tr>
	  <tr>
	   <td>Canvas, SVG</td><td>2</td><td>2</td>
	  </tr>
	  <tr>
	   <td>Smarty</td><td>1</td><td>2/3</td>
	  </tr>
	  <tr>
	   <td>Twitter Bootstrap</td><td>1</td><td>2/3</td>
	  </tr>
	  <tr>
	   <td>CodeIgniter</td><td>1</td><td>2/3</td>
	  </tr>
	  </tbody>
	 </table>
	</dd>

   </dl>
  </div>
 </div>
 <aside class="note">
  <p>* Skill level: 1 – Theoretical knowledge; 2 - Junior; 3 – Confirmed experience; 4 – Advanced experienced; 5 – Senior expert.</p>
 </aside>
</section>
-->