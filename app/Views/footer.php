        </div>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="jsModal" tabindex="-1" aria-labelledby="jsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="jsModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


            </div>
          </div>
        </div>
      </div>
      <!-- fim modal -->

      <div id="toasters" class="position-fixed top-0 end-0 mt-5 p-3" style="z-index: 11">
      </div>

      <script>
        const caminho = "<?= base_url() ?>";
        const enviroment = "<?= ENVIRONMENT ?>";
        const gc_maxlifetime = "<?=date('Y/m/d H:i', strtotime('+'.ini_get('session.gc_maxlifetime'). ' seconds')) ?>";
      </script>

      <script src="<?= base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
      <!--<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js') ?>" type="text/javascript"></script>-->
      <script src="<?= base_url('assets/js/datatables.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/waitingfor.js') ?>" type="text/javascript"></script>
      <!--<script src="<?= base_url('ckeditor5-build-classic/ckeditor.js') ?>" type="text/javascript"></script>-->
      <script src="<?= base_url('ckeditor5/build/ckeditor.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('ckfinder/ckfinder.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.mask.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.cookie.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/bootstrap-select.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/bootstrap-select-defaults-pt_BR.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.redirect.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.countdown.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/jquery.number.js') ?>" type="text/javascript"></script>
      <script src="<?= base_url('assets/js/adm.js') ?>" type="text/javascript"></script>



      </body>

      </html>