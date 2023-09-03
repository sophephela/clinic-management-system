<?php
if(session_status() < 2){
    session_start();
}

 if(isset($_SESSION['error'])) { ?>
     <div class="popup popup--icon -error js_error-popup popup--visible">
         <div class="popup__background"></div>
         <div class="popup__content">
             <h3 class="popup__content__title">
                 Error
             </h3>
             <p class="text-danger"><?php echo $_SESSION['error']; ?></p>
             <button class="button button--error" data-for="js_error-popup" onclick="$('.popup').hide()">Close</button>

         </div>
     </div>
 <?php } unset($_SESSION['error']);

if(isset($_SESSION['success'])){?>
    <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                Success
            </h3>
            <p class="text-success"><?php echo $_SESSION['success']?></p>
            <script>setTimeout(function(){$('.popup').hide()},8000)</script>
        </div>
    </div>
<?php } unset($_SESSION['success']);?>


<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function () {
            var popupEl = document.querySelector('.' + el.dataset.for);
            popupEl.classList.toggle('popup--visible');
        });
    };

    Array.from(document.querySelectorAll('button[data-for]')).
    forEach(addButtonTrigger);

    $(function() {
        $(document).ready(function () {
            $('#dom-jqry').DataTable();
            $('#users_table').DataTable();
            $('#driver_table').DataTable();
            $('#teacher_table').DataTable();
            $('#admin_table').DataTable();
            $('#transport_table').DataTable();
        });

    });
</script>
