// JavaScript Document
function deleteBrand(obj) {
		var id = $(obj).attr('id'); //alert('id='+id);
		var el = $(obj).parent();
		$.ajax({
			url: '/trademarks/removeTracked?id='+id,
			success: function(msg)
			{
				if (msg == 'OK')
				{
					el.fadeOut(300, function(){
							el.remove();
					});
				}
			}
		});	
}

function doubleConfirm(obj){
	
	var r = confirm("This action can not be undone and\n the selected trademark will be deleted permanently!\n\nPress OK to delete or Cancel to abort this action.");
    if (r == true) {
        deleteBrand(obj);
    } else {
        return;
    }
}


$(document).on('ready', function() {
    $(window).on('resize', function() {
        var highestSessCol = Math.max(
										  $('.qfSessCellEqHghtHolder .qfSessCellEqHght01').height(),
										  $('.qfSessCellEqHghtHolder .qfSessCellEqHght02').height(),
										  $('.qfSessCellEqHghtHolder .qfSessCellEqHght03').height()
									  );
		$('.qfSessCellEqHghtHolder .qfSessCellEqHght').css('min-height', highestSessCol + 'px');
    }).trigger('resize');
});

$(document).ready(function(){
	
	$("#uploadBtn_1").click(function(){
        $(this).parents(".wrapUpItem").find("#filesToUpload1").trigger('click');
    });
	$("#uploadBtn_2").click(function(){
        $(this).parents(".wrapUpItem").find("#filesToUpload2").trigger('click');
    });

    var wHeight = $(window).height();
    var headerheight = $('.qfHeaderWrap').height();
    var endbtmheight = wHeight - headerheight;

    $('.qfContainerBlock').css('min-height', endbtmheight + 'px');

     /* make the two main columns with equal height */            
    var qfMainNavHeight = $('.qfMainNav').height();
    $('.qfMainBody').css('min-height', qfMainNavHeight + 'px');
    var qfMainBodyHeight = $('.qfMainBody').height();
    $('.qfMainNav').css('min-height', qfMainBodyHeight + 'px');

    //expand additional form fields
    $(".hideFmPart").click(function(event){
        $(this).toggleClass("qfFmSelected");
        if ($(this).hasClass("qfFmSelected")){
            $(this).text("Покажи допълнителните полета");
            $(".qfTogFmPiece").slideUp();
        } else {
            $(this).text("Скрий допълнителните полета");
            $(".qfTogFmPiece").slideDown(); 
        }
    });

    $(".qfUpListitem .qfUpLeft").click(function(event){
        $(this).toggleClass("qfUpListItemSelected");
		$(this).parent(".qfUpListitem").find(".qfUpRight").toggleClass("qfUpRightListItemSelected");
        if ($(this).hasClass("qfUpListItemSelected")){
            $(this).parents(".wrapUpItem").find(".qfUpExpand").slideDown();
        } else {
            $(this).parents(".wrapUpItem").find(".qfUpExpand").slideUp();
        }
    });

    $(".qfSearchTag").click(function(event){
        $(this).toggleClass("qfSearchTagSelected");
        if ($(this).hasClass("qfSearchTagSelected")){
            $(this).parents(".qfSearchWrap").find(".qfSearchListWrapExpand").slideDown();
        } else {
            $(this).parents(".qfSearchWrap").find(".qfSearchListWrapExpand").slideUp();
        }
    });
    
	/*
    $(".qfTrMarkItemDelete").click(function(event){
        $(this).parent(".qfTrMarkItem").fadeOut(300, function(){ 
            $(this).remove();
        });
    });
    */
    
    var url = "upload-progress.php";    
    $(".qfUpFlImg").click(function(event){
        $(this).change(function() { 
            $(location).attr('href',url);  
        }); 
    });


//FILTER TRADEMARKS IN THE TRACKED TRADEMARKS VIEW
    var countmarks= $('div.qfTrMarkItem').length;
   // $( ".qfEntryHeader span" ).append( "<span class='qfCountTrademarks'>&nbsp;(" + countmarks + ")</span>" );
    
	$('select[name="filter01"]').change(function(){
		// hide all
		var value = $(this).val();
        var countmarks= $('div.qfTrMarkItem').length;
        var countmarksfiltered = $(".qfTrMarkItemOpt_"+value).length;
        
		$('#trademarks_container').fadeOut(400, function(){
			$('.qfTrMarkItem').hide();
			
			if (value == "all")
			{
				$('.qfTrMarkItem').show(10, function(){
					$('#trademarks_container').fadeIn(400);
				});
                $( ".qfEntryHeader span span.qfCountTrademarks" ).remove();
                $( ".qfEntryHeader span" ).append( "<span class='qfCountTrademarks'>&nbsp;(" + countmarks + ")</span>" );
			}
			else
			{
				$(".qfTrMarkItemOpt_"+value).show(10, function(){
					$('#trademarks_container').fadeIn(400);
				});
                $( ".qfEntryHeader span span.qfCountTrademarks" ).remove();
                $( ".qfEntryHeader span" ).append( "<span class='qfCountTrademarks'>&nbsp;(" + countmarksfiltered + ")</span>" );
			}
		
		});
		
	});
//SORT BY NAME OR DATE
	$('select[name="filter02"]').change(function(){
		if ($(this).val() == "sort_name")
		{
			var container = $('#trademarks_container');
			var items = container.children('div.qfTrMarkItem').get();
			var sorted = items.sort(function(a,b){
				return $(a).find("a.qfTrMarkTitle").text() > $(b).find("a.qfTrMarkTitle").text();
			});
			$("#trademarks_container").html(sorted);
		}
		if ($(this).val() == "sort_date")
		{
			var container = $('#trademarks_container');
			var items = container.children('div.qfTrMarkItem').get();
			var sorted = items.sort(function(a,b){
			    //console.log($(a).data('sort'));
				return $(a).data('sort') > $(b).data('sort');
			});
			$("#trademarks_container").html(sorted);
		}
		$('select[name="filter01"]').trigger('change');
	});



//SEARCH FUNCTIONALITY
	function updatecount(){
		var countmarks2= $('div.qfTrMarkItem:visible').length;
		//alert(countmarks2);
		$( ".qfEntryHeader span span.qfCountTrademarks" ).remove();
        $( ".qfEntryHeader span" ).append( "<span class='qfCountTrademarks'>&nbsp;(" + countmarks2 + ")</span>" );
	}

	$('input[name=search]').change(function(){
		
		var query = $(this).val();
		if(!query) {
			$('#trademarks_container').fadeOut(400, function() {
				$('.qfTrMarkItem').show(10, function(){
					$('#trademarks_container').fadeIn(400, function (){updatecount();});
				});
			});
			return;
		}
		
		$('#trademarks_container').fadeOut(400, function() {
			var allBrands = $('.qfTrMarkTitle');
			var count = allBrands.length;
			$('.qfTrMarkTitle').each(function(index, element) {
			  
			  var index = $(element).text().indexOf(query);
			  console.log(index);
			  if (index == -1) {
				 $(element).parents('.qfTrMarkItem').hide()
			  }else {
				$(element).parents('.qfTrMarkItem').show();
				//$(element).parents('.qfTrMarkItem').addClass("randomClass");
				
				//alert(countmarks2);
				
			  }
			 
			 if (!--count) $('#trademarks_container').fadeIn(300, function (){updatecount();});
			 
			  
			});
		
		});
		
	});
	
	
	
	
//DELETE ITEMS FROM LIST AND DB	
	
	
$(".qfTrMarkItemDelete").confirm({
    text: "Are you sure you want to delete this trademark? All of the data associated with it will be lost and can not be recovered!",
    title: "Confirmation required",
    confirm: function(el) {
        doubleConfirm(el);
    },
    cancel: function(button) {
        // do something
    },
    confirmButton: "Yes I am",
    cancelButton: "No",
    post: true
});



         
});

$(function() {
    $("#progressbar").progressbar({
        value: 1
    });
    $("#progressbar > .ui-progressbar-value").animate({
        width: "100%"
    }, 2000);
});