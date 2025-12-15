<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset]);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/favicon.png')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title ?: 'Project Management System') ?></title>
    <?php $this->head() ?>

    <!-- ✅ Google Font & Bootstrap Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* 🌈 Navbar Styling */
        .navbar {
            background: rgba(0, 71, 171, 0.8);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
            color: #fff !important;
        }

        .nav-link {
            color: #f5f5f5 !important;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #00e1ff !important;
            text-shadow: 0 0 8px rgba(0, 255, 255, 0.5);
        }

        /* 🌸 Container Content */
        .container {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        /* 🧭 Breadcrumb */
        .breadcrumb {
            background: #ffffff;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* 🦋 Footer */
        footer {
            background: linear-gradient(90deg, #0047AB, #00B4D8);
            color: white;
            font-size: 0.9rem;
            padding: 15px 0;
            margin-top: auto;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.1);
        }

        footer a {
            color: #fff;
            text-decoration: underline;
        }

        footer a:hover {
            color: #d1ecff;
        }

        /* 💠 Button Animation */
        .btn-custom {
            background: linear-gradient(90deg, #007bff, #00b4d8);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, #00b4d8, #48cae4);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 180, 216, 0.4);
        }

        /* 🌙 Dark Mode Toggle (Optional) */
        .dark-mode {
            background: #0d1117 !important;
            color: #e6edf3 !important;
        }

        /* 🌈 Navbar Styling - TAMBAHKAN INI */
        .navbar-nav {
            flex-wrap: nowrap !important;
            /* Mencegah wrap ke baris baru */
            overflow-x: auto !important;
            /* Tambahkan scroll horizontal jika terlalu panjang */
            white-space: nowrap !important;
            /* Mencegah teks wrap */
        }

        .navbar-nav .nav-item {
            flex-shrink: 0 !important;
            /* Mencegah item menyusut */
            margin-right: 8px !important;
            /* Jarak antar item */
        }

        /* Optional: untuk tampilan mobile, hilangkan scroll jika tidak diperlukan */
        @media (max-width: 992px) {
            .navbar-nav {
                overflow-x: visible !important;
            }
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- 🌟 Navbar -->
    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => '<i class="bi bi-shield-lock-fill"></i> <b>Project Management</b>',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar navbar-expand-lg navbar-dark fixed-top'],
        ]);

        $menuItems = [
            ['label' => '<i class="bi bi-house-door"></i> Home', 'url' => ['/site/index']],

            ['label' => '<i class="bi bi-people"></i> Users', 'url' => ['/user/index']],
            ['label' => '<i class="bi bi-folder2-open"></i> Projects', 'url' => ['/project/index']],
            ['label' => '<i class="bi bi-list-task"></i> Tasks', 'url' => ['/task/index']],
            ['label' => '<i class="bi bi-chat-left-text"></i> Comments', 'url' => ['/comments/index']],

            ['label' => '<i class="bi bi-wallet2"></i> Budget', 'url' => ['/budget/index']],
            ['label' => '<i class="bi bi-graph-up-arrow"></i> Activity Log', 'url' => ['/activity-log/index']],
            ['label' => '🔔 Notifications', 'url' => ['/notification/index']],
            ['label' => '📅 Calendar', 'url' => ['/calendar/index']],


        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '<i class="bi bi-box-arrow-in-right"></i> Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li class="nav-item">'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline'])
                . Html::submitButton(
                    '<i class="bi bi-box-arrow-right"></i> Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                    ['class' => 'nav-link btn btn-link text-light fw-bold']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto gap-2 align-items-center'],
            'items' => $menuItems,
            'encodeLabels' => false,
        ]);

        NavBar::end();
        ?>
    </header>

    <!-- 🌼 Main Content -->
    <main id="main" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'],
                    'options' => ['class' => 'breadcrumb px-3 py-2 shadow-sm'],
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <div class="card bg-white p-4 rounded-4 shadow-sm mt-3">
                <?= $content ?>
            </div>
        </div>
    </main>

    <!-- ⚡ Footer -->
    <footer class="text-center">
        <div class="container">
            <div class="small">
                © <?= date('Y') ?> <strong>Project Management System</strong>
                | Designed by <a href="#">Daniel Ndara Palako</a> 💻
                | Powered by <a href="https://www.yiiframework.com/" target="_blank">Yii2 + Bootstrap 5</a>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>