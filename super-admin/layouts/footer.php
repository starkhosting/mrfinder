</div>
          </div>
        </div>
      </div>
    </div>
  </div>

 

<script type="text/javascript">
    $(document).ready(function(){
      $('.userinfo').click(function(){
        var get_id =$(this).data('id');
        // alert(get_id)
          $.ajax({
            url: 'view.php',
            type: 'post',
            data:{get_id: get_id},
            success: function(response){
              $('.modal-body').html(response);
              $('#viewModal').modal('show');
            }
          });
      });
    });
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->
</body>
</html>