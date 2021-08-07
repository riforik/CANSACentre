/**
* @name Gallery - APP.JS
* @author Isaiah Robinson
* @organization CANSA Centre For Community and Cultural Development
* @date 06-14-2021
*
* Purpose:
* This script controls the gallery page of the CANSA Centre website
* being the backbone of functionality and how the images are displayed.
*
* Also while communicating with the gallery template-part.
*/

// on document load
document.addEventListener('DOMContentLoaded', function() {
  // gallery page element
  const GALLERY_EL        = document.getElementById('gallery-row'),
        SORT_EL_ASC       = document.getElementById("sortAsc"),
        SORT_EL_DESC      = document.getElementById("sortDesc"),
        SORT_DESK_EL_ASC  = document.getElementById("sortAscDesk"),
        SORT_DESK_EL_DESC = document.getElementById("sortDescDesk"),
        VIEW_SELECT       = document.getElementById("gallery-view"),
        EVENT_SELECT      = document.getElementById("gallery-event"),
        SHOW_NAV          = document.getElementById('showNav'),
        SORT_DATE         = document.getElementById('sort-date'),
        SORT_DATE_DESK    = document.getElementById('sort-date-desktop'),
        EVENT_DATE_LIST   = document.getElementById('event-dates-list'),
        GALLERY_NAV       = document.querySelectorAll(".gallery-nav"),
        SINGLE_EVENT      = document.getElementsByClassName("single-event"),
        FORM_VIEW         = document.getElementsByClassName("view-option"),
        COLUMNS           = 4;

  // Only proceed if on http://www.cansacentre.com/gallery/
  if (GALLERY_EL) {

    // RESET OPTION MENUS
    VIEW_SELECT.selectedIndex  = 0; // reset view select
    VIEW_SELECT.disabled       = true; // disable view select
    EVENT_SELECT.selectedIndex = 0; // reset event select
    $('input[name="event_options"]').prop('checked', false);
    $('input[name="view_options"]').prop('checked', false);
    $('input[id="column-radio"]').prop('checked', true);

    // Gallery image elements
    const GALLERY_ARRAY = document.getElementsByClassName('gallery-item');

    let gallery_photos = [], // array for sorted photos, main
        arr_Inc        = Math.round(GALLERY_ARRAY.length / COLUMNS), // gallery / COLUMNS
        arrCounter     = arr_Inc, // array counter integer
        currentGallery = [], // array reserved for saving galleries the current state
        evFrstOpen     = 0, // first event change tracker, for splashScreen()
        content        = '<article id="gallery-row" class="gallery-row"><aside class="column">';

        let vVal = 0;
        let eventValue = "";

    /*** H E L P E R    F U N C T I O N S **/
    /**
    * @function {function} splashScreen
    *
    * Splash screen that prevents images from display until an event choice
    * @callback {function} initializeGallery
    * @callback {function} changeEvent
    */
    function splashScreen(eVal) {
      if (evFrstOpen === 0) {
        let emptyOption = document.getElementsByClassName(".emptyOption");
        $(GALLERY_EL).hide(); // hide the gallery
      } else if (evFrstOpen === 1){
        $(GALLERY_EL).css('display', 'flex'); // show the gallery
        initializeGallery();
        changeEvent(eVal);

        $('.gallery-splash').remove(); // remove the splash page
        $('.emptyOption').remove(); // remove the placeholder event options
        $('#event_radio br:first-child').remove(); // hide the splash page
        VIEW_SELECT.disabled = false; // Enable view change select & sort buttons
        $("#sortAsc").attr("disabled", false);
        $("#sortDesc").attr("disabled", false);
        $("#sortAscDesk").attr("disabled", false);
        $("#sortDescDesk").attr("disabled", false);
        $("input[name='view_options']").removeAttr( "disabled" );
        $("input[name='sort-date']").removeAttr( "disabled" );
        $("input[name='sort-date-desktop']").removeAttr( "disabled" );
        $(EVENT_DATE_LIST).removeAttr( "disabled" );
      } else {
        changeEvent(eVal);
      }
      evFrstOpen += 1;
    }


    /**
    * @function {function} initializeGallery
    *
    * 1. take the gallery on the pasge and display
    * 2. use portions and place them in aside "columns"
    * 3. display the new gallery format on the DOM
    * @callback {function} populateGalleryPhotos
    */
    function initializeGallery() {

      arrCounter = arr_Inc; // start tracker at the gallery portion #
      content = '<article id="gallery-row" class="gallery-row"><aside class="column">';
      for (var i = 0; i < GALLERY_ARRAY.length; i++) {

        // current gallery item variable
        let currGalItem = GALLERY_ARRAY[i].childNodes[1].firstElementChild.firstElementChild;
        let currGalData = GALLERY_ARRAY[i].childNodes[1].firstElementChild.lastElementChild

        // Custom PHP = firstElementChild, WordPress = firstChild
        GALLERY_ARRAY[i].childNodes[1].firstElementChild.href = GALLERY_ARRAY[i].childNodes[1].firstElementChild.firstElementChild.src

        if (currGalData.dataset.name) {
          currGalItem.dataset.name = currGalData.dataset.name;
          currGalItem.dataset.slug = currGalData.dataset.slug;
          currGalItem.dataset.date = currGalData.dataset.date;
        } else {
          currGalItem.dataset.name = "Other";
          currGalItem.dataset.slug = "Other";
          currGalItem.dataset.date = "";
        }

        // add current variable item data to an array of objects

        populateGalleryPhotos(currGalItem, i, GALLERY_ARRAY[i].childNodes[1].classList);

        // if the loop has iterated a quarter of the gallery length
        if (i === arrCounter) {
          // increase array counter by a quarter of the gallery length
          arrCounter += arr_Inc;
          // insert column element
          content += `</aside><aside class="column">`;
          content += `${GALLERY_ARRAY[i].outerHTML}`; // add gallery item
        } else {
          content += `${GALLERY_ARRAY[i].outerHTML}`; // add gallery item
        }
      }
      content += "</article>"; // close content article element
      document.getElementById('gallery-row').outerHTML = content;
      content = ''; // empty content
    };


    /**
    * @function {function} getItemDate
    *
    * Convert upload directory date to a Date variable
    * @param    {Array} item    image item from the gallery
    * @param    {Int}   i       iteration var from callback loop
    * @return   {Date}          New Date object
    */
    function getItemDate(item, i) {
      // let srcSplit = item.src.split("uploads/"); // get uploads directory
      let itemDate = item.dataset.date.split("-"); // split month and year
      // itemDate.pop(); // create a date from the uploads directory in the URL
      let curMnth = itemDate[1] - 1;
      // console.log(itemDate[1]);
      // console.log(`${itemDate[0]}, ${curMnth}, ${i}`);

      // return a date variable with the month and year
      return new Date(itemDate[0], curMnth, itemDate[2], 0, i);
    }


    /**
    * @function {function} populateGalleryPhotos
    *
    * Add current variable item data to an array of objects
    * @param    {Array} item      image item from the gallery
    * @param    {Int}   i         iteration var from callback loop
    * @param    {Array} divClass  class list from the images containing element
    */
    function populateGalleryPhotos(item, i, divClass) {
      // add current variable item data to an array of objects
      gallery_photos.push({
        className: `${item.className}`,
        divClass : divClass,
        source   : `${item.src}`,
        height   : `${item.height}`,
        width    : `${item.width}`,
        sizes    : `${item.sizes}`,
        loading  : `${item.loading}`,
        srcset   : `${item.srcset}`,
        alt      : `${item.alt}`,
        event    : `${item.dataset.slug}`,
        postDate : `${item.dataset.date}`,
        date     : getItemDate(item, i)
      });
      currentGallery = gallery_photos;
    }


    /**
    * @function {function} orderDesc
    *
    * Oder the gallery by descending date order
    * @callback {function}    populatePage
    */
    function orderDesc() {
      currentGallery.sort((a, b) => b.date - a.date);
      currentGallery.reverse();
      populatePage(currentGallery);
    };

    /**
    * @function {function} orderAsc
    *
    * Order the gallery by ascending date order
    * @callback {function}    populatePage
    */
    function orderAsc() {
      currentGallery.sort((a, b) => b.date - a.date);
      populatePage(currentGallery);
    };


    /**
    * @function {function} populatePage
    *
    * Fill the web page with gallery images
    * @param    {Array}       gallery used to populate the page with content
    * @callback {function}    mosaicView
    * @callback {function}    masonryView
    * @callback {function}    fullView
    */
    function populatePage(gallery) {
      let viewSelectVal = vVal;
      currentGallery = gallery;
      arrCounter = arr_Inc;
      content = '<article id="gallery-row" class="gallery-row">';

      if (viewSelectVal === 0) {
        content += `<aside class="column">`;
      } else if (viewSelectVal === 1) {
        content += `<aside class="masonry">`;
      } else if (viewSelectVal === 2) {
        content += `<aside class="full">`;
      } else {
        return;
      };
      // for each gallery item
      for (var j = 0; j < gallery.length; j++) {

        // if the loop has iterated a quarter of the gallery length
        if (j === arrCounter) {
          // increase array counter by a quarter of the gallery length
          arrCounter += arr_Inc;

          /**
          * Determine how the content is arranged before displaying
          *
          * 0 = column view
          * 1 = masonry view
          * 2 = full view
          */
          if (viewSelectVal === 0) { // 0
            mosaicView(gallery, j);
          } else { // 1
            masonryView(gallery, j);
          }
        } else { // 2
          fullView(gallery, j);
        }
      }
      content += "</article>"; // close content article element
      // populate page by sort order
      document.getElementById('gallery-row').outerHTML = content;
    }


    /**
    * @function {function} isBigPhoto
    *
    * Measure the image aspect ratio and assign a class based on size
    * @param {Int}  width    images width attribute
    * @param {Int}  height   images height attribute
    */
    function isBigPhoto(width, height) {
      let widthHeightRatio = height / width * 100;
      if (widthHeightRatio >= 0 && widthHeightRatio <= 64) {
        return 'landscape';
      } else  if (widthHeightRatio >= 65 && widthHeightRatio <= 75) {
        return 'big';
      } else {
        return 'portrait';
      }
    }


    /**
    * @function {function} mosaicView
    *
    * Change the display orientation to the mosaic view mode
    * @param    {Array}     gallery    gallery images array
    * @param    {Int}       j          callback function loop iteration variable
    * @return   {String}               content variable that gets sent to the DOM
    * @callback {function}  isBigPhoto
    */
    function mosaicView(gallery, j) {

      content += `
        </aside><aside class="column">
        <figure class="gallery-item ${isBigPhoto(gallery[j].width, gallery[j].height)}">`;

      content += `
          <div class="${gallery[j].divClass[0]}">
            <a href="${gallery[j].source}" target="_blank">
              <img src="${gallery[j].source}" class="${gallery[j].className}" alt="" loading="${gallery[j].loading}" srcset="${gallery[j].srcset}" sizes="${gallery[j].sizes}" width="${gallery[j].width}" height="${gallery[j].height}">
            </a>
          </div>
        </figure>
      `;
      return content;
    }


    /**
    * @function {function} masonryView
    *
    * Change the display orientation to the masonry view mode
    * @param    {Array}     gallery    gallery images array
    * @param    {Int}       j          callback function loop iteration variable
    * @return   {String}               content variable that gets sent to the DOM
    * @callback {function}  isBigPhoto
    */
    function masonryView(gallery, j) {
      // give "big" class name to large photos
      content += `
        <figure class="gallery-item ${isBigPhoto(gallery[j].width, gallery[j].height)}">`;
      content += `
        <div class="${gallery[j].divClass[0]}">
          <a href="${gallery[j].source}" target="_blank">
            <img src="${gallery[j].source}" class="${gallery[j].className}" alt="" loading="${gallery[j].loading}" srcset="${gallery[j].srcset}" sizes="${gallery[j].sizes}" width="${gallery[j].width}" height="${gallery[j].height}">
          </a>
        </div>
      </figure>
      `;
      return content;
    }


    /**
    * @function {function} fullView
    *
    * Change the display orientation to the full view mode
    * @param    {Array}     gallery    gallery images array
    * @param    {Int}       j          callback function loop iteration variable
    * @return   {String}               content variable that gets sent to the DOM
    * @callback {function}  isBigPhoto
    */
    function fullView(gallery, j) {
      // give "big" class name to large photos
      content += `
        <figure class="gallery-item ${isBigPhoto(gallery[j].width, gallery[j].height)}">`;
      // continue regular content
      content += `
        <div class="${gallery[j].divClass[0]}">
          <a href="${gallery[j].source}" target="_blank">
            <img src="${gallery[j].source}" class="${gallery[j].className}" alt="" loading="${gallery[j].loading}" srcset="${gallery[j].srcset}" sizes="${gallery[j].sizes}" width="${gallery[j].width}" height="${gallery[j].height}">
          </a>
        </div>
      </figure>
      `;
      return content;
    }


    /**
    * @function {function} changeEvent
    *
    * Filter out events based on the event select value
    * @callback {function}  populatePage
    */
    function changeEvent(eVal) {
      let evIndex = eVal;
      let galEvent = gallery_photos.filter(gallery_photo => gallery_photo.event.includes(evIndex));

      if (EVENT_SELECT.value === 'All Events') {
        arr_Inc = Math.round(gallery_photos.length / COLUMNS);
        populatePage(gallery_photos);
      } else {
        arr_Inc = Math.round(galEvent.length / COLUMNS);
        populatePage(galEvent);
      }

        /**
        * Restrict date picker min and max to match selected event
        *  - currentGallery array = event photo array
        *  - sort array based on date
        */
        document.getElementsByName("sort-date")[0].setAttribute('min', galEvent[0].postDate);
        document.getElementsByName("sort-date")[0].setAttribute('max', galEvent[galEvent.length - 1].postDate);
        document.getElementsByName("sort-date-desktop")[0].setAttribute('min', galEvent[0].postDate);
        document.getElementsByName("sort-date-desktop")[0].setAttribute('max', galEvent[galEvent.length - 1].postDate);
        content = "";
        let datesArray = [];
        for (var i = 0; i < galEvent.length; i++) {
          datesArray.push(galEvent[i].postDate);
        }
        let datesConcat = [...new Set(datesArray)];
        for (var i = 0; i < datesConcat.length; i++) {
          let curDate = datesConcat[i].split("-");
          content += `<option value="${curDate[1]}/${curDate[2]}/${curDate[0]}">${curDate[1]}/${curDate[2]}/${curDate[0]}</option>`
        };

        $(EVENT_DATE_LIST).html(content);
    }

    /**
    * @function {function} changeEvent
    *
    * Display and hide the gallery navigation
    */
    function showNav() {
      if ($(GALLERY_NAV).css('display') == 'none') {
        // Open Nav
        $(GALLERY_NAV).slideDown();
        $(SHOW_NAV).css({
          "transform": "rotate(180deg)"
        });
      } else {
        // Close Nav
        $(GALLERY_NAV).slideUp();
        $(SHOW_NAV).css({
          "transform": "rotate(0deg)"
        });
      }
    }


    /**
    * @function {function} changeEvent
    *
    * Filter out events based on the date input value
    * @callback {function}  populatePage
    */
    function sortDate(date) {
      changeEvent(eventValue);

      let dateItm = currentGallery.filter(galItm => galItm.postDate == date);
      if (dateItm.length > 0) {
        arr_Inc = Math.round(dateItm.length / COLUMNS);
        populatePage(dateItm);
      } else {
        // do nothing.
      }
    }


    // Load Splash Screen
    splashScreen();

    /**
    * CONTROLLERS
    *
    * Event Handlers for the interactable elements in the gallery
    */
    VIEW_SELECT.addEventListener("change", function() {
      vVal = VIEW_SELECT.selectedIndex;
      populatePage(currentGallery);
    });
    EVENT_SELECT.addEventListener("change", function () {
      eventValue = EVENT_SELECT.value;
      splashScreen(EVENT_SELECT.value);
    });
    SORT_EL_ASC.addEventListener("click", orderAsc);
    SORT_EL_DESC.addEventListener("click", orderDesc);
    SORT_DESK_EL_ASC.addEventListener("click", orderAsc);
    SORT_DESK_EL_DESC.addEventListener("click", orderDesc);
    SHOW_NAV.addEventListener("click", showNav);
    $('#event_radio').change(function(){
        let selected_value = $("input[name='event_options']:checked").val();
        if (evFrstOpen === 1) {
          splashScreen(selected_value);
        }
        eventValue = selected_value;
        splashScreen(selected_value);
    });
    $('#view_radio').change(function(){
        let view_value = $("input[name='view_options']:checked").val();
        vVal = parseInt(view_value);
        populatePage(currentGallery);
    });
    $(SORT_DATE).change(function(){
        let date_value = $("input[name='sort-date']").val(); // date picker
        sortDate(date_value); // YYYY-MM-DD format split (Y-m-d)
    });
    $(SORT_DATE_DESK).change(function(){
        let date_value = $("input[name='sort-date-desktop']").val(); // date picker
        sortDate(date_value); // YYYY-MM-DD format split (Y-m-d)
    });

  } else {
    return; // this script will do nothing if the gallery doesn't exist.
  }
});
