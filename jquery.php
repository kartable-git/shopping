<script>
    $(document).ready(function(){
        load_pdt();
        load_cart_data();
        function load_pdt(){
            $.ajax({
                url:"fetch_item.php",
                method:"POST",
                success:function(data){
                    $('#display_item').html(data);

                }
            })
        }
        function load_cart_data(){
            $.ajax({
                url:"fetch_cart.php",
                method:"POST",
                dataType:"json",
                success:function(data){
                    $('#cart_details').html(data.cart_details);
                    $('.total_price').text(data.total_price);
                    $('.badge').text(data.total_item);
                }
            })
        }
        $('#cart-popover').popover({
            html:true,
            container:'body',
            content:function(){
                return $('#popover_content_wrapper').html();
            }
        });
        $(document).on('click','.add_to_cart',function(){
             var pdt_id=$(this).attr('id');
             var pdt_name=$('#name'+pdt_id+'').val();
             var pdt_price=$('#price'+pdt_id+'').val();
             var pdt_qnty=$('#qnty'+pdt_id).val();
             var action ='add';
             if(pdt_qnty>0){
                $.ajax({
                url:"action.php",
                method:"POST",
                data:{pdt_id:pdt_id,pdt_name:pdt_name,pdt_price:pdt_price,
                pdt_qnty:pdt_qnty,action:action},
                success:function(data){
                    load_cart_data();
                    alert("Item(s) has been Added");
                }
            })
             }
             else{
                 alert("Please Enter Number of Quantity");
             }
        });
        $(document).on('click','.delete',function(){
             var pdt_id=$(this).attr('id');
             var action ='rmv';
             if(confirm("Sure about Deletein?")){
                $.ajax({
                url:"action.php",
                method:"POST",
                data:{pdt_id:pdt_id,action:action},
                success:function(data){
                    load_cart_data();
                    $('#cart-popover').popover('hide');
                    alert("Item(s) has been Removed");
                }
            })
             }
             else{
                return false;
             }
        });
        $(document).on('click','#clear_cart',function(){
             var action ='empty';
            
                $.ajax({
                url:"action.php",
                method:"POST",
                data:{action:action},
                success:function(data){
                    load_cart_data();
                    $('#cart-popover').popover('hide');
                    alert("Cart has been Cleared");
                }
            })
            
        });
    });
</script>