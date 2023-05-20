function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    console.log('Scan result: ${decodedText}', decodedResult);
    document.getElementById('result').innerHTML = '<input class="result" type="text" name="post_name" value="' + decodedText + '">';
    setTimeout(
        () => {
            document.forms[1].submit();
            
        },
        2 * 1000
    );
    

}
 

var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", {
        fps: 10,
        qrbox: 250
    });
html5QrcodeScanner.render(onScanSuccess);
