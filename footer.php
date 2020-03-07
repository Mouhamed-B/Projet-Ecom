<!-- Footer -->
<footer class="py-5 bg-dark footer mt-4">
  <div class="container-fluid">
    <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
  </div>
  <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/js/script.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/popper.js/popper.min.js"></script>
<?php if ($_SERVER['SCRIPT_NAME']=='/Checkout.php') : ?><script src="js/form-validation.js"></script><?php endif?>
<?php if ($_SESSION['alert']===true) :?>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#modal').trigger('click')
      })
    </script>
  <?php unset($_SESSION['alert']); 
  endif ?>
</body>

</html>