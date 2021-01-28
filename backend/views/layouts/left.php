<aside class="main-sidebar">

	<section class="sidebar">

		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
			</div>
			<div class="pull-left info">
				<p><?= Yii::$app->user->identity->username ?> <?= Yii::$app->user->identity->last_name ?></p>

				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form -->
       <?php if (false): ?>
			 <form action="#" method="get" class="sidebar-form">
				 <div class="input-group">
					 <input type="text" name="q" class="form-control" placeholder="Search..."/>
					 <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
				 </div>
			 </form>
       <?php endif; ?>
		<!-- /.search form -->

       <?= dmstr\widgets\Menu::widget([
             'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
             'items' => [
                ['label' => 'Menu', 'options' => ['class' => 'header']],
                ['label' => 'Main', 'icon' => 'home', 'url' => ['/site']],
                [
                   'label' => 'Analytics and Reports',
                   'icon' => 'pie-chart',
                   'url' => '#',
                   'items' => [
                      ['label' => 'Restaurants', 'icon' => 'cutlery', 'url' => ['/restaurant']],
                      ['label' => 'General', 'icon' => 'bar-chart-o', 'url' => ['/report/general']],
                   ],
                ],
                ['label' => 'Users', 'icon' => 'users', 'url' => ['/user']],
                ['label' => 'Delivery (Diggernaut)', 'icon' => 'truck', 'url' => ['/delivery']],
                ['label' => 'Cuisines', 'icon' => 'coffee', 'url' => ['/cuisine-types/index']],
                ['label' => 'Platforms', 'icon' => 'flag', 'url' => ['/platform']],
                [
                   'label' => 'Messages',
                   'icon' => 'commenting',
                   'url' => '#',
                   'items' => [
                      ['label' => 'Support requests', 'icon' => 'comments', 'url' => ['/messages/support-requests']],
                      //['label' => 'Notifications', 'icon' => 'bell', 'url' => ['/messages/notifications']],
                   ],
                ],
                [
                   'label' => 'Pages',
                   'icon' => 'file-text',
                   'url' => '#',
                   'items' => [
                      ['label' => 'FAQs', 'icon' => 'file-text', 'url' => ['/page/update?id=1']],
                      ['label' => 'About Foodbud', 'icon' => 'file-text', 'url' => ['/page/update?id=2']],
                   ],
                ],
                [
                   'label' => 'Tools',
                   'icon' => 'cog',
                   'url' => '#',
                   'items' => [
                      ['label' => 'Admin', 'icon' => 'user', 'url' => ['/admin']],
                      ['label' => 'Manage emails', 'icon' => 'edit', 'url' => ['/email-template']],
                      ['label' => 'Logs', 'icon' => 'th-list', 'url' => ['/log']],
                       /*[
                          'label' => 'Level One',
                          'icon' => 'circle-o',
                          'url' => '#',
                          'items' => [
                             ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                             [
                                'label' => 'Level Two',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                   ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                   ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                ],
                             ],
                          ],
                       ],*/
                   ],
                ],
                ['label' => 'Logout','icon' => 'sign-out', 'url' => ['auth/logout']],

             ],
          ]) ?>

	</section>

</aside>
