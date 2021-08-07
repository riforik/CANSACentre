/**
* @name YouTube - YOUTUBE.JS
* @author Isaiah Robinson
* @organization CANSA Centre For Community and Cultural Development
* @date 08-04-2021
*
* Purpose:
* This script controls the Live page of the CANSA Centre website
* as well as the zoom links on individual event post pages.
*
* being the backbone of functionality and YouTube channel data is manipulated
* onto various web pages.
*/


// On Document Load
document.addEventListener('DOMContentLoaded', function() {

  // Global Variables (Script Scope)
  const YOUTUBE_URL = "https://www.youtube.com/embed/live_stream?channel =UC7npkTN7u8Tbl2gRjAYZFcQ",
        YOUTUBE_ID  = "UC7npkTN7u8Tbl2gRjAYZFcQ",
        TEST_URL    = "https://www.youtube.com/embed/live_stream?channel =UCeY0bbntWzzVIaj2z3QigXg",
        API_KEY     = "AIzaSyCbrP4zdc7-dBQBa6Qa4Hqzwy3WntgwoM4",
        ZOOM_LINKS  = document.querySelector(".zoom"),
        PLAYLIST    = document.querySelector(".events"),
        MONTHS      = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        ZOOM_BUTTON = document.getElementById('showZoom'),
        ZOOM_LIST   = document.getElementById("list"),
        SING_EVNT   = document.getElementsByClassName("single-event");

  // load Google API client
  gapi.load("client");


  /*** H E L P E R    F U N C T I O N S **/
  /**
  * @function {function} loadClient
  *
  * Load the Google API client so that requests for playlist data can be made.
  * @return {Gapi} loaded google api "client"
  */
  function loadClient() {
    gapi.client.setApiKey(API_KEY);
    return gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
      .then(function() {
          console.log("GAPI client loaded for API");
        },
        function(err) {
          $("#list").html("<span>Playlist Empty</span>");
          $("#showZoom").html(`Zoom Videos (0)`);
          $(".zoom-loading").remove();
          console.error("Error loading GAPI client for API", err);
        });
  }


  /**
  * @function {function}   execute
  *
  * Grab the playlist data from youtube
  * **Make sure the client is loaded before calling this method.**
  * @param    {String}     playlistID   ID of the events playlist dataset
  * @callback {function} showZoomLinks
  */
  function execute(playlistID) {
    return gapi.client.youtube.playlistItems.list({
        "part": [
          "snippet,contentDetails"
        ],
        "maxResults": 2500,
        "playlistId": playlistID
      })
      .then(function(response) {
          // Handle the results here (response.result has the parsed body).
          $(".zoom-loading").remove();
          showZoomLinks(response.result.items);
        },
        function(err) {
          $("#list").html("<span>Playlist Empty</span>");
          $("#showZoom").html(`Zoom Videos (0)`);
          $(".zoom-loading").remove();
          console.error("Execute error", err);
        });
  }


  /**
  * @function {function}   hasPlaylist
  *
  * @param    {String}     playlist     list of CANSA Centre playlists
  * @return {bool} if the corresponding  playlist exists on the YouTube channel.
  */
  function hasPlaylist(playlist) {
    if (playlist.dataset.playlist) {
      return true;
    } else {
      return false;
    }
  }


  /**
  * @function {function}   showZoomLinks
  *
  * Display the zoom links on the individual event posts page.
  * @param    {String}     data            list of CANSA Centre playlists items
  */
  function showZoomLinks(data) {
    data.reverse();
    let content = `<hr>`;
    let vidDate;
    if (data) {
      for (var i = 0; i < data.length; i++) {
        /**
        * @param data[i]  snippet           channelId
        * @param data[i]  snippet           title
        * @param data[i]  contentDetails    publishedAt
        * @param data[i]  contentDetails    videoId
        */
        vidDate = new Date(data[i].contentDetails.videoPublishedAt);
        content += `
        <li class="item ff-grid-4">
          <p>
            <a target="_blank" href="https://www.youtube.com/watch?v=${data[i].contentDetails.videoId}">
              <span class="date">
                <time datetime="${vidDate.getFullYear()}-${vidDate.getMonth()}-${vidDate.getDay() + 1}">${MONTHS[vidDate.getMonth()]} ${vidDate.getDay() + 1}, ${vidDate.getFullYear()}</time>
                </span>
              <span>${data[i].snippet.title}</span>
            </a>
          </p>
        </li>`;
      }
      $("#list").html(content);
      $("#showZoom").html(`Zoom Videos (${data.length})&nbsp;<i class="fas fa-caret-down"></i>`);
    } else {
      content += "<span>Playlist Empty</span>";
      $("#list").html(content);
      $("#showZoom").html(`Zoom Videos (${data.length})`);
    }
  }


  // Controllers
  // if there are zoom links
  if (ZOOM_LINKS && hasPlaylist(PLAYLIST)) {
    // load Google API client
    gapi.load("client");

    setTimeout(function() {
      loadClient();
    }, 1000);
    setTimeout(function() {
      let playlistID = PLAYLIST.dataset.playlist.split("list="); // get playlist id
      execute(playlistID[1]);
    }, 3000);
  }

  // open and close zoom links element
  if (SING_EVNT) {
    function showList() {
      if ($(ZOOM_LIST).css('display') == 'none') {
        $(ZOOM_LIST).slideDown();
      } else {
        $(ZOOM_LIST).slideUp();
      }
    }
    // Event Handler
    ZOOM_BUTTON.addEventListener("click", showList);
  }

  // Remove the loading spinner after 3.1 seconds
  setTimeout(function() {
    $(".zoom-loading").remove();
  }, 3100);

}); // on load
