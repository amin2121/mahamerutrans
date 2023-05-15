<footer class="footer text-center"> 2021 &copy; Ababil Software Solution </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <?php if($this->session->flashdata('status') == 'success') : ?>
        <div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-success myadmin-alert-top alert-action"> <i class="ti-check"></i> <?= $this->session->flashdata('message') ?> <a href="#" class="closed">&times;</a> </div>
    <?php else : ?>
        <div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger myadmin-alert-top alert-action"> <i class="ti-check"></i> <?= $this->session->flashdata('message') ?> <a href="#" class="closed">&times;</a> </div>
    <?php endif ?>

    <!-- /#wrapper -->
    <!-- jQuery -->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url() ?>assets/bootstrap/dist/js/tether.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>assets/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url() ?>assets/js/custom.min.js"></script>

    <!-- Real estate dashboard JavaScript -->
    <!-- <script src="<?= base_url() ?>assets/js/real-estate.js"></script> -->
    <script src="<?= base_url() ?>assets/js/js-form.js"></script>
    <script src="<?= base_url() ?>assets/js/pagination.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <!-- jQuery peity -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/peity/jquery.peity.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/peity/jquery.peity.init.js"></script>
    <!--Style Switcher -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <!-- Magnific popup JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script> -->
    <!-- jQuery file upload -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/cleave/dist/cleave.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        // Date Picker
        jQuery('.mydatepicker, #datepicker').datepicker({
            toggleActive: true,
            format: 'dd-mm-yyyy',
        });

        jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
        });

        jQuery('#date-range').datepicker({
                toggleActive: true,
                format: 'dd-mm-yyyy',
        });
        jQuery('#datepicker-inline').datepicker({
                todayHighlight: true
        });

        // Daterange picker

        $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
        });

        $('.input-daterange-timepicker').daterangepicker({
                timePicker: true,
                format: 'MM/DD/YYYY h:mm A',
                timePickerIncrement: 30,
                timePicker12Hour: true,
                timePickerSeconds: false,
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse'
        });

        function reverse_date(date) {
            return date.split("-").reverse().join("-");
        }

        $(document).ready(function() {
                let status = '<?= $this->session->flashdata('status') ?>' == 'danger' ? 'error' : '<?= $this->session->flashdata('status') ?>'
                let notif = '<?= $this->session->flashdata('message') ?>'

                if(notif != '') {
                    $(`.alert-action`).fadeToggle(350);
                    setTimeout(() => $(".myadmin-alert .closed").click(), 2000)
                }

                $(".myadmin-alert .closed").click(function(event) {
                        $(this).parents(".myadmin-alert").fadeToggle(350);

                        return false;
                });

                $('.dropify').dropify();
                $(".select2").select2();

                $('.input-time').toArray().forEach(function(field){
                        new Cleave(field, {
                                time: true,
                                timePattern: ['h', 'm', 's']
                        })
                });

                $('.image-popup-no-margins').magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        closeBtnInside: false,
                        fixedContentPos: true,
                        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
                        image: {
                                verticalFit: true
                        },
                        zoom: {
                                enabled: true,
                                duration: 300 // don't foget to change the duration also in CSS
                        }
                });

        })

        function show_loading_table(param, count_col) {
                let loading = `<tr id="loading-table">
                      <td class="text-center" colspan="${count_col}">
                        <img src="<?= base_url('assets/loading-table.gif') ?>" alt="<?= base_url('assets/loading-table.gif') ?>" width="70">
                      </td>
                </tr>`

                $(`${param}`).html(loading)
        }

        function show_error_loading(param, count_col) {
                $(`${param}`).html(`<tr colspan="${count_col}"><td class="text-center">Loading Data Gagal, Silahkan Refresh Ulang</td></tr>`)
        }
    </script>
</body>

</html>
