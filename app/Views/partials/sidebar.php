<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('/') ?>" class="brand-link">
        <img src="<?= base_url('logo-bhisa.png') ?>" alt="Bhisa Logo"
            class="brand-image elevation-3" style="opacity: .8; background: white; border-radius: 8px;">
        <span class="brand-text font-weight-bold">&nbsp;</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('dist/img/avatar.png') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= session('name') ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            $menus = [
                (object) [
                    'title' => 'MENU UTAMA',
                ],
                (object) [
                    'icon' => 'fas fa-tachometer-alt',
                    'name' => 'Dashboard',
                    'link' => '/dashboard',
                    'childs' => [],
                ],
                (object) [
                    'icon' => 'fas fa-book',
                    'name' => 'Product',
                    'link' => '/product',
                    'childs' => [],
                ],
                (object) [
                    'icon' => 'fas fa-user',
                    'name' => 'Purchasing Staff',
                    'link' => '/staff',
                    'childs' => [],
                ],
                (object) [
                    'icon' => 'fas fa-file-invoice',
                    'name' => 'Invoice',
                    'link' => '/invoice',
                    'childs' => [],
                ],
                (object) [
                    'title' => 'AKUN PENGGUNA',
                ],
                (object) [
                    'icon' => 'fas fa-user',
                    'name' => 'Profil Akun',
                    'link' => '/profile',
                ],
            ];
            ?>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <?php foreach ($menus as $menu): ?>
                    <?php if (isset($menu->title)): ?>
                        <li class="nav-header"><?= $menu->title ?></li>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php if (isset($menu->is_admin) && $menu->is_admin && session('user_role') !== 'admin'): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php
                    $hasActiveChild = false;
                    if (isset($menu->childs) && count($menu->childs)) {
                        foreach ($menu->childs as $child) {
                            if (strpos(current_url(), trim($child->link, '/')) !== false) {
                                $hasActiveChild = true;
                                break;
                            }
                        }
                    }
                    ?>
                    <li class="nav-item <?= $hasActiveChild ? 'menu-open' : '' ?>">
                        <a class="nav-link <?= ((!isset($menu->childs) || !count($menu->childs)) && strpos(current_url(), trim($menu->link, '/')) !== false) || $hasActiveChild ? 'active' : '' ?>"
                            href="<?= isset($menu->childs) && count($menu->childs) ? '#' : base_url($menu->link) ?>">
                            <i class="nav-icon <?= $menu->icon ?>"></i>
                            <p><?= $menu->name ?></p>
                            <?php if (isset($menu->childs) && count($menu->childs)): ?>
                                <i class="right fas fa-angle-left"></i>
                            <?php endif; ?>
                        </a>
                        <?php if (isset($menu->childs) && count($menu->childs)): ?>
                            <ul class="nav nav-treeview"
                                style="<?= $hasActiveChild ? 'display: block;' : 'display: none;' ?>">
                                <?php foreach ($menu->childs as $child): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= strpos(current_url(), trim($child->link, '/')) !== false ? 'active' : '' ?>"
                                            href="<?= base_url($child->link) ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= $child->name ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item">
                    <form id="logout-form" action="<?= base_url('logout') ?>" method="POST" style="display: none;">
                        <?= csrf_field() ?>
                    </form>
                    <a href="#" class="nav-link" id="logout-button">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<script>
    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>