(function(window, undefined) {
  'use strict';

  /*
  NOTE:
  ------
  PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
  WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */

	$(function(){
		$('.box-pagination ul').addClass('justify-content-end');
		$('.box-pagination ul li').addClass('page-item');
		$('.box-pagination ul li a').addClass('page-link');
	});
	
	if ($('.pickadate_birthday').length) {
		$('.pickadate_birthday').pickadate({
				
				format: 'dd/mm/yyyy'
		});
	}
	
	 
	if($('.flat-blue').length){
		$('.flat-blue').on('ifChecked', function(event){
				$(this).closest('tr').css('background', 'rgb(10 188 28 / 0.1)');
		});
		$('.flat-blue').on('ifUnchecked', function(event){
				$(this).closest('tr').removeAttr('style');
		});
	}

	/* Profile Select2 */
	if($(".select2_profile").length){
		$(".select2_profile").select2({
			dropdownAutoWidth: true,
			width: '100%',
			dropdownParent: $('#modal_profile'),
			containerCssClass: 'select-sm'
		});
	}

	/* Profile Datepicker */
	if($('.pickadate-months-year').length){
		$('.pickadate-months-year').pickadate({
		    selectYears: true,
		    selectMonths: true
		});
	}
	/* Confirn Remove Avatar */

	$('.remove-avatar').click(function(e) {
			e.preventDefault();
			$(this).closest('.box').find('.js--confirn-remove').addClass('show');
	});
	
	$('.btn-remove-close').click(function(e) {
			e.preventDefault();
			$(this).closest('.box').find('.js--confirn-remove').removeClass('show');
	});
	
	
	function initImageUpload(box) {
		let uploadField = box.querySelector('.image-upload');

		uploadField.addEventListener('change', getFile);

		function getFile(e){
			let file = e.currentTarget.files[0];
			checkType(file);
		}
		
		function previewImage(file){
			let thumb = box.querySelector('.js--image-preview'),
					reader = new FileReader();

			reader.onload = function() {
				thumb.style.backgroundImage = 'url(' + reader.result + ')';
			}
			reader.readAsDataURL(file);
			thumb.className += ' js--no-default';
		}

		function checkType(file){
			let imageType = /image.*/;
			if (!file.type.match(imageType)) {
				throw 'Datei ist kein Bild';
			} else if (!file){
				throw 'Kein Bild gewählt';
			} else {
				previewImage(file);
			}
		}
		
	}

	// initialize box-scope
	var boxes = document.querySelectorAll('.box');

	for(let i = 0; i < boxes.length; i++) {if (window.CP.shouldStopExecution(1)){break;}
		let box = boxes[i];
		initDropEffect(box);
		initImageUpload(box);
		removeElement(box);
	}
	window.CP.exitedLoop(1);


	function removeElement(box) {
    let uploadField = box.querySelector('.image-upload');
    uploadField.parentNode.removeChild(uploadField);
}


	/// drop-effect
	function initDropEffect(box){
		let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;
		
		// get clickable area for drop effect
		area = box.querySelector('.js--image-preview');
		area.addEventListener('click', fireRipple);
		
		function fireRipple(e){
			area = e.currentTarget
			// create drop
			if(!drop){
				drop = document.createElement('span');
				drop.className = 'drop';
				this.appendChild(drop);
			}
			// reset animate class
			drop.className = 'drop';
			
			// calculate dimensions of area (longest side)
			areaWidth = getComputedStyle(this, null).getPropertyValue("width");
			areaHeight = getComputedStyle(this, null).getPropertyValue("height");
			maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

			// set drop dimensions to fill area
			drop.style.width = maxDistance + 'px';
			drop.style.height = maxDistance + 'px';
			
			// calculate dimensions of drop
			dropWidth = getComputedStyle(this, null).getPropertyValue("width");
			dropHeight = getComputedStyle(this, null).getPropertyValue("height");
			
			// calculate relative coordinates of click
			// logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
			x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
			y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;
			
			// position drop and animate
			drop.style.top = y + 'px';
			drop.style.left = x + 'px';
			drop.className += ' animate';
			e.stopPropagation();
			
		}
	}
	
	
	
})(window);