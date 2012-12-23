function urlencode(str) {
    str = (str+'').toString();
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
        replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}

function getPageImages() {
    
    var imgTags = document.body.getElementsByTagName('img');
    var images = new Array();
    
    if (videoThumbUrl) {
        var image = new Image();
        image.src = videoThumbUrl;
        image.isVideo = true;
        
        // we don't know yet the size of the image, so if the image element is
        // displayed already, set the size accordingly
        image.onload = function() {
            var imgEl = document.getElementById("img_0");
            var imgSizeEl = document.getElementById("img_size_0");
            if (imgEl != null && imgSizeEl != null) {
                setImageSizeAndPosition(imgEl, image, imgSizeEl);
            }
        };
        images.push(image);
    }
    
    for (var i=0; i<imgTags.length; i++) {
        
        // test image size
        if (imgTags[i].width < 200 || imgTags[i].height < 200){
            continue;
        }

        // was it found already?
        var found = false;
        for (var j=0; j<i; j++) {
            if (imgTags[i].src == imgTags[j].src) {
                found = true;
                break;
            }
        }
        
        if (!found) {
            imgTags[i].isVideo = false;
            images.push(imgTags[i]);
        }
    }
    
    return images;
}

function bookmark(url, isVideo) {
        
    // var documentUrl = 'http://upload'+domain+'/pin/button?image_url='+urlencode(url)+'&source_url='+urlencode(location.href);
    var documentUrl = 'http://'+domain+'/user/record/upload?image_url='+urlencode(url)+'&source_url='+urlencode(location.href);
    if (document.referrer) {
        documentUrl += "&referrer_url="+urlencode(document.referrer);
    }
    if (isVideo) {
        documentUrl += "&video=1";
    }
    
    var pinpornWindow = window.open(documentUrl,'name','width=900,height=650');
    if (window.focus) {
        pinpornWindow.focus();
    }
    
    // close js popup
    destroyOverlay();
}

function destroyOverlay() {
    document.body.removeChild(document.getElementById("porn_iframe"));
    document.body.removeChild(document.getElementById("porn_full_overlay"));
    document.body.removeChild(document.getElementById("porn_popup"));
}

function pinThisOver(id){
    var idObj = document.getElementById('pinThis-'+id);
    idObj.style.display= 'block';
}

function pinThisOut(id){
    var idObj = document.getElementById('pinThis-'+id);
    idObj.style.display= 'none';
}

function setImageSizeAndPosition(imageEl, imageObj, imageSizeEl) {
    
    var topMargin = 0;
    var leftMargin = 0;
    var imageWidth = 0;
    var imageHeight = 0;
    
    if (imageObj.width > imageObj.height) { // landscape
        topMargin = Math.floor(( 200 - (200 * imageObj.height / imageObj.width)) / 2);
        imageWidth = 200;
        imageHeight = Math.round(200 * imageObj.height / imageObj.width);
    } else if (imageObj.width < imageObj.height) {
        leftMargin = Math.floor(( 200 - (200 * imageObj.width / imageObj.height)) / 2);
        imageWidth = Math.round(200 * imageObj.width / imageObj.height);
        imageHeight = 200;
    }

    imageEl.style.margin    = topMargin+"px "+leftMargin+"px";
    imageEl.style.width     = imageWidth+"px";
    imageEl.style.height    = imageHeight+"px";
    
    // set the text
    imageSizeEl.innerHTML = imageObj.width+' X '+imageObj.height;
}

function displayImages(container, images){
        
    var titleDiv = document.createElement("div");
    titleDiv.style.position= "relative";
    titleDiv.style.display = "block";
    titleDiv.style.height = "43px";
    titleDiv.style.borderBottom = "solid 1px #f2f0f0";
    
    // get app folder from domain
    var appFolder = domain.substring(1).replace('.com', '');
    titleDiv.style.background = "#faf7f7 url(http://www"+domain+"/images/"+appFolder+"/popup_logo.png) center center no-repeat";
    
    var cancelButtonWrapper = document.createElement("div");
    cancelButtonWrapper.style.position = "absolute";
    cancelButtonWrapper.style.right = "20px";
    cancelButtonWrapper.style.top = "10px";
    cancelButtonWrapper.style.textDecoration = "none";
    cancelButtonWrapper.style.fontWeight = "bold";
    cancelButtonWrapper.style.color = "#524D4D";
    cancelButtonWrapper.style.textShadow = "0 1px rgba(255, 255, 255, 0.9)";
    cancelButtonWrapper.style.display = "inline-block";
    cancelButtonWrapper.style.textAlign = "center";
    cancelButtonWrapper.style.padding = "2px 6px";
    cancelButtonWrapper.style.border = "1px solid #BBB";
    
    var cancelButton = document.createElement("a");
    cancelButton.setAttribute("href", "javascript:destroyOverlay();");
    cancelButton.style.textDecoration = "none";
    cancelButton.style.fontSize = "12px";
    cancelButton.style.color = "rgb(0, 0, 0)";
    cancelButton.appendChild(document.createTextNode("CANCEL PIN [X]"));
    
    var imagesContainer = document.createElement("div");
    imagesContainer.style.padding = "20px";
    
    for (var i=0; i<images.length; i++) {
        
        var imageSize = document.createElement("div");
        imageSize.style.backgroundColor  = "#cccccc";
        imageSize.style.color  = "#000";
        imageSize.style.padding  = "5";
        imageSize.style.textAlign = 'center';
        imageSize.setAttribute("id", "img_size_"+i);
                
        var imageWrapper = document.createElement("div");
        imageWrapper.style.border = "1px solid #cccccc";
        imageWrapper.style.cssFloat = "left";
        imageWrapper.style.float = "left";
        imageWrapper.style.width = "200px";
        imageWrapper.style.height = "228px";
        imageWrapper.style.margin = "4px 4px 0 0";
        imageWrapper.style.position = "relative";
        imageWrapper.setAttribute('onmouseover','pinThisOver('+i+')');
        imageWrapper.setAttribute('onmouseout','pinThisOut('+i+')');
        
        var imagePlay = document.createElement("a");
        imagePlay.style.position = "absolute";
        imagePlay.style.zIndex  = "2147483646";
        imagePlay.setAttribute("href", "javascript:bookmark('"+images[i].src+"', "+images[i].isVideo+")");
        imagePlay.style.width = "60px";
        imagePlay.style.height = "60px";
        imagePlay.style.top="60px";
        imagePlay.style.left="70px";
        
        var imageObjPlay = document.createElement("img");
        imageObjPlay.style.width = "60px";
        imageObjPlay.style.height = "60px";
        imageObjPlay.style.border = "none";
        imageObjPlay.setAttribute("src", 'http://www'+domain+'/images/small_play_button.png');
        
        var imagePinThis = document.createElement("a");
        imagePinThis.style.position = "absolute";
        imagePinThis.style.zIndex  = "2147483647";
        imagePinThis.setAttribute("href", "javascript:bookmark('"+images[i].src+"', "+images[i].isVideo+")");
        imagePinThis.style.width = "124px";
        imagePinThis.style.height = "30px";
        imagePinThis.style.top="84px";
        imagePinThis.style.left="38px";
        imagePinThis.style.display="none";
        imagePinThis.setAttribute("id","pinThis-"+i);
        
        var imageObjPinThis = document.createElement("img");
        imageObjPinThis.style.width = "124px";
        imageObjPinThis.style.height = "30px";
        imageObjPinThis.style.border = "none";
        imageObjPinThis.setAttribute("src", 'http://www'+domain+'/images/button_pin_this.png');     
        
        var imageLink = document.createElement("a");
        imageLink.setAttribute("href", "javascript:bookmark('"+images[i].src+"', "+images[i].isVideo+")");
        
        var imageObj = document.createElement("img");
        imageObj.style.border = "none";
        imageObj.setAttribute("id", "img_"+i);
        
        setImageSizeAndPosition(imageObj, images[i], imageSize);
        
        imageObj.setAttribute("src", images[i].src);

        imageLink.appendChild(imageObj);
        imagePinThis.appendChild(imageObjPinThis);
        imageWrapper.appendChild(imagePinThis);
        if (images[i].isVideo) {
            imagePlay.appendChild(imageObjPlay);
            imageWrapper.appendChild(imagePlay);
        }
        imageWrapper.appendChild(imageLink);
        imageWrapper.appendChild(imageSize);
        imagesContainer.appendChild(imageWrapper);
    }
    
    var spacer = document.createElement("div");
    spacer.style.float = "none";
    spacer.style.clear = "both";
    spacer.style.height = "0px";
    spacer.style.lineHeight = "0px";
    
    spacer.appendChild(document.createTextNode(" "));
    imagesContainer.appendChild(spacer);

    cancelButtonWrapper.appendChild(cancelButton);
    titleDiv.appendChild(cancelButtonWrapper);
    container.appendChild(titleDiv);
    container.appendChild(imagesContainer);
    
}

function createOverlay(images) {
    
    if (document.getElementById("porn_full_overlay") != null) {
        return;
    }
    
    // get document height (cross-browser)
    var height = Math.max(
            Math.max(document.body.scrollHeight, document.documentElement.scrollHeight),
            Math.max(document.body.offsetHeight, document.documentElement.offsetHeight),
            Math.max(document.body.clientHeight, document.documentElement.clientHeight)
            );
    
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id","porn_iframe");
    iframe.setAttribute("width", "100%");
    iframe.setAttribute("height", "100%");
    iframe.style.position = "absolute";
    iframe.style.top = "0px";
    iframe.style.right = "0px";
    iframe.style.bottom = "0px";
    iframe.style.left = "0px";
    iframe.style.zIndex = "2147483643";
    iframe.style.background = "transparent";
    iframe.style.border = "none";
    
    var fullOverlay = document.createElement("div");
    fullOverlay.setAttribute("id","porn_full_overlay");
    
    fullOverlay.style.position = "absolute";
    fullOverlay.style.top = "0px";
    fullOverlay.style.left = "0px";
    fullOverlay.style.width = "100%";
    fullOverlay.style.height = height+"px";
    fullOverlay.style.opacity = "0.5";
    fullOverlay.style.zIndex = "2147483644";
    fullOverlay.style.filter = "alpha(opacity=70)";
    fullOverlay.style.background = "black";
    
    var popupDiv = document.createElement("div");
    popupDiv.setAttribute("id","porn_popup");
    popupDiv.style.position = "absolute";
    popupDiv.style.top = "0px";
    popupDiv.style.left = "50%";
    popupDiv.style.width = "870px";
    popupDiv.style.zIndex = "2147483645";
    popupDiv.style.margin = "40px 0 0 -415px";
    popupDiv.style.background = "rgb(255, 255, 255)";
    popupDiv.style.textAlign = "left";
    
    displayImages(popupDiv, images);

    document.body.appendChild(iframe);
    document.body.appendChild(fullOverlay);
    document.body.appendChild(popupDiv);
    
    scroll(0,0);
}

// check if pinning is allowed
var allowPin = true;
var metaTags = document.getElementsByTagName("meta");
for (var i=0 ; i<metaTags.length ; i++) {
    if (metaTags[i].name !== undefined && metaTags[i].name.toLowerCase() == "pinporn" && metaTags[i].content !== undefined && metaTags[i].content == "nopin" ) {
        allowPin = false;
        alert("The owner from this site doesn't allow pinning to PinPorn from this page. Please contact the owner with any questions.");
    }
}

console.log("domain", domain);
// check if user is pinning from pinporn
if (document.location.href.indexOf(domain) != -1) {

    console.log("dom dom");
    allowPin = false;
    alert("Your bookmarklet is installed! Now you can click your Pin Porn button to pin images as your browser porn sites around the web.");
}

var videoApi;
var videoThumbUrl = "";
var images;

if (allowPin) {
    
    console.log("allowing pin");
    // insert video api
    // videoApi = document.createElement("script");
    // videoApi.type = "text/javascript";
    // videoApi.src = "http://upload"+domain+"/javascript/tube_site_api.php?url="+escape(document.location.href);
    // document.body.appendChild(videoApi);
    images = getPageImages();
    if (images.length == 0) {
        alert("No image found in this document");
    } else {
        createOverlay(images);
    }
}