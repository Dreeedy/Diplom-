<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Меню</span>
            </h4>

            <div class="list-group mb-3">
                <div class="mb-1">
                    <a href="../index.php">
                        <button class="w-100 btn btn-md btn-outline-danger text-start">Назад</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о бракосочетании</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о усыновлении</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о рождении</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о смерти</button>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Регистрация клиента</h4>
            <form action="../customersController.php" method="post" class="needs-validation" novalidate="">

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="surname" class="visually-hidden">Фамилия</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия"
                               value="<?php echo $_SESSION['REGISTER']['inputSurname'] ?>" minlength="2" maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="name" class="visually-hidden">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Имя"
                               value="<?php echo $_SESSION['REGISTER']['inputSurname'] ?>" minlength="2" maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="middleName" class="visually-hidden">Отчество</label>
                        <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Отчество"
                               value="<?php echo $_SESSION['REGISTER']['inputSurname'] ?>" minlength="2" maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="address" class="visually-hidden">Адрес</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Адрес"
                               value="<?php echo $_SESSION['REGISTER']['inputSurname'] ?>" minlength="2" maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="phoneNumber" class="visually-hidden">Номер телефона</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                               placeholder="+7 495 123-45-67"
                               value="<?php echo $_SESSION['REGISTER']['inputSurname'] ?>" minlength="10" maxlength="15"
                               required="">
                    </div>
                </div>

                <button class="w-100 btn btn-primary btn-lg" type="submit">Регистрация клиента</button>
            </form>
        </div>
    </div>
</div>
