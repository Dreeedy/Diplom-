<div class="container">
    <div style="min-height: 873px;">
        <div class="album py-5 <!--bg-light-->">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?
                    if ($_SESSION['code'] == 3)
                    {
                        require_once "blocks/menu_staff.php";
                        require_once "blocks/statistic_menu.php";

                        require_once "blocks/customers_menu.php";

                        require_once "blocks/customers_&_book_acts_menu.php";

                        require_once 'blocks/acts_marriage_menu.php';
                        require_once 'blocks/acts_birth_menu.php';
                        require_once 'blocks/acts_adoption_menu.php';
                        require_once 'blocks/acts_death_menu.php';
                    }
                    if ($_SESSION['code'] == 2)
                    {
                        require_once "blocks/customers_menu.php";

                        require_once "blocks/customers_&_book_acts_menu.php";

                        require_once 'blocks/acts_marriage_menu.php';
                        require_once 'blocks/acts_birth_menu.php';
                        require_once 'blocks/acts_adoption_menu.php';
                        require_once 'blocks/acts_death_menu.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>