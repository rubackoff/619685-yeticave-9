<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            echo include_template('categories_nav.php', [
                'categories' => $categories,
            ]);
            ?>
        </ul>
    </nav>
    <?php $invalid = count($errors) ? "form--invalid" : ""; ?>
        <form class="form container <?= $invalid; ?>" action="sign-up.php" method="post" autocomplete="off">
            <h2>Регистрация нового аккаунта</h2>
            <?php
            $classname = isset($errors['email']) ? "form__item--invalid" : "";
            $value = isset($form['email']) ? $form['email'] : "";
            ?>
            <div class="form__item <?= $classname; ?>" >
                <label for="email">E-mail <sup>*</sup></label>
                <input id="email" type="text" name="email" value="<?= $value; ?>">
                <span class="form__error"><?= $errors['email'] ; ?></span>
            </div>
            <?php
            $classname = isset($errors['password']) ? "form__item--invalid" : "";
            $value = isset($form['password']) ? $form['password'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="password">Пароль <sup>*</sup></label>
                <input id="password" type="password" name="password" value="<?= $value; ?>">
                <span class="form__error">Введите пароль</span>
            </div>
            <?php
            $classname = isset($errors['name']) ? "form__item--invalid" : "";
            $value = isset($form['name']) ? $form['name'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="name">Имя <sup>*</sup></label>
                <input id="name" type="text" name="name" value="<?= $value; ?>">
                <span class="form__error">Введите имя</span>
            </div>
            <?php
            $classname = isset($errors['message']) ? "form__item--invalid" : "";
            $value = isset($form['message']) ? $form['message'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="message">Контактные данные<sup>*</sup></label>
                <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= $value; ?></textarea>
                <span class="form__error">Напишите как с вами связаться</span>
            </div>
            <?php if (isset($errors)): ?>
                <div class="form__errors">
                    <p>Пожалуйста, исправьте следующие ошибки:</p>
                    <ul>
                        <?php foreach ($errors as $err => $val): ?>
                            <li><strong><?= $dict[$err]; ?>: </strong><?= $val; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <button type="submit" class="button">Зарегистрироваться</button>
            <a class="text-link" href="login.php">Уже есть аккаунт</a>
        </form>
    </main>
