<header>
    <div class="blog-header py-2 border-bottom shadow-sm">
        <div class="container">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a href="../index.php">
                        <img class="" src="/icons/favicon.svg" alt="" width="38px" height="38px">
                    </a>
                </div>
                <div class="col-4 text-center">
                    <h3 class="col-11">ЗАГС ИК МО "ЛМР" РТ</h3>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <h5 class="me-2 mb-0"><? echo $_SESSION['inputSurname'].' '.$_SESSION['inputName'].' '.$_SESSION['inputMiddleName']?></h5>
                    <a class="btn btn-sm btn-outline-danger" href="../logout.php">Выйти</a>
                </div>
            </div>
        </div>
    </div>
</header>