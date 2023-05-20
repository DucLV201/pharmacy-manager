<?php
    use Gloudemans\Shoppingcart\Facades\Cart;
    $content =   Cart::content();
?>
@foreach($content as $v_content)
  <form id="update-form-{{$v_content->rowId}}">
  <input type="number" min="1" value="{{$v_content->qty}}" class="soluongsp text-center cart-quantity" name="cart_quantity" data-rowid="{{$v_content->rowId}}">
    
    
  </form>
  <div class="giamoi" data-rowid="{{$v_content->rowId}}" style="margin-top:-20px">
                                                <?php  $subtotal = $v_content->price * $v_content->qty;
                                                    echo number_format($subtotal) ;
                                                ?>đ
                                            </div> 
@endforeach

<p class="tongcong">{{Cart::subtotal()}} ₫</p>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.cart-quantity').change(function(e) {
      e.preventDefault();
      var rowId = $(this).data('rowid');
      var quantity = $(this).val();

      $.ajax({
        url: '{{URL::to("/test1")}}',
        method: 'POST',
        data: {
          rowid: rowId,
          cart_quantity: quantity,
          _token: '{{csrf_token()}}'
        },
        success: function(response) {
            $('.tongcong').text(response.subtotal + ' ₫');
            $('.giamoi[data-rowid="' + rowId + '"]').text(response.price + ' ₫');
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    });
  });
</script>
