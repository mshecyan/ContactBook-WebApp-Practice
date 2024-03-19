<div class="bg">
    <div class="content-box">
        <div class="menu-panel">
            <div class="menu">
                <div class="title">Панель управления записями</div>
                <a class="button sign-out-btn" href="/admin/sign_out.php">Выйти</a>
            </div>
        </div>
        <div class="subtitle">Всего записей: <?= $totalContactsCount; ?> </div>
        <div class="contact-list">
            <?php foreach($contacts as $row) { ?>
            <div class="item">
                <div class="item-data">
                    <div class="item-photo">
                        <img class="user-photo" src=" <?= $row['photo']; ?> ">
                    </div>
                    <div class="item-contacts">
                        <div class="item-name"> <?= $row['name']; ?> </div>
                        <div class="item-email">
                            <div class="icon-email"></div>
                            <div class="caption"> <?= $row['email']; ?> </div>
                        </div>
                        <div class="item-phone">
                            <div class="icon-phone"></div>
                            <div class="caption"> <?= (!empty($row['phone'])) ? $row['phone'] : 'Не указан'; ?> </div>
                        </div>
                    </div>
                </div>
                <div class="item-onreg">Дата заполнения:<br> <?= $row['on_reg']; ?> </div>
                <div class="item-control">
                    <a href="delete_contact.php?id=<?= $row['id'] ?>&page=<?= $page ?>" class="item-delete-btn">
                        <div class="icon delete-btn"></div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="pagination">
            <?php for ($i=1; $i <= $pagesCount; $i++) { ?>
                <a class="page <?php if ($page == $i) { echo 'active-page'; } ?>" href="/admin/index.php?page=<?= $i ?>"> <?= $i ?> </a>
            <?php } ?>
        </div>
    </div>
</div>