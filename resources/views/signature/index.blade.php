<!DOCTYPE html>
<html>
<head>
    <title>Signature Pad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <style>
        .signature-pad {
            border: 1px solid #000;
            border-radius: 4px;
            background-color: #fff;
            cursor: crosshair;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Draw or Upload Signature</h5>
        </div>
        <div class="card-body">
            <form id="signatureForm" onsubmit="return false;">
                <div class="form-group">
                    <label>Method:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="method" id="methodDraw" value="draw" checked>
                        <label class="form-check-label" for="methodDraw">Draw</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="method" id="methodUpload" value="upload">
                        <label class="form-check-label" for="methodUpload">Upload</label>
                    </div>
                </div>

                <div id="draw-section">
                    <label>Draw Signature:</label>
                    <div style="border: 2px solid #000; border-radius: 4px; background: #fff;">
                        <canvas id="signature-pad" class="signature-pad" width="600" height="200"></canvas>
                    </div>
                    <button id="clear" class="btn btn-danger btn-sm mt-2">Clear</button>
                </div>

                <div id="upload-section" style="display:none;">
                    <label>Upload PNG/JPG:</label>
                    <input type="file" id="signature_file" class="form-control" accept="image/png,image/jpeg">
                </div>

                <button class="btn btn-success mt-3" id="saveSignature">Save & Send to Parent</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    // Make canvas responsive
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    // Clear button
    document.getElementById('clear').addEventListener('click', function(e){
        e.preventDefault();
        signaturePad.clear();
    });

    // Method switching
    document.querySelectorAll('input[name="method"]').forEach(function(radio){
        radio.addEventListener('change', function(){
            if(this.value === 'draw'){
                document.getElementById('draw-section').style.display = 'block';
                document.getElementById('upload-section').style.display = 'none';
                signaturePad.clear();
            } else {
                document.getElementById('draw-section').style.display = 'none';
                document.getElementById('upload-section').style.display = 'block';
                signaturePad.clear();
            }
        });
    });

    // Get target input ID from query string
    const urlParams = new URLSearchParams(window.location.search);
    const targetInput = urlParams.get('target');

    // Save signature
    document.getElementById('saveSignature').addEventListener('click', function(e){
        e.preventDefault();

        const method = document.querySelector('input[name="method"]:checked').value;
        let signatureData = '';

        if(method === 'draw'){
            if(signaturePad.isEmpty()){
                alert('Please draw your signature first');
                return;
            }
            signatureData = signaturePad.toDataURL('image/png');
            sendToParent(signatureData);
        } else {
            const fileInput = document.getElementById('signature_file');
            const file = fileInput.files[0];
            
            if(!file){ 
                alert('Please upload a file'); 
                return; 
            }

            const reader = new FileReader();
            reader.onload = function(e){
                signatureData = e.target.result;
                sendToParent(signatureData);
            }
            reader.readAsDataURL(file);
        }
    });

    function sendToParent(signatureData){
        if(targetInput && window.opener){
            const input = window.opener.document.getElementById(targetInput);

            // Determine corresponding preview ID
            let previewId = 'signPreview'; // default for borrower
            if(targetInput === 'sign_superior') previewId = 'signPreview_superior';
            if(targetInput === 'sign_ict') previewId = 'signPreview_ict';

            const preview = window.opener.document.getElementById(previewId);

            if(input){
                input.value = signatureData;
                if(preview){
                    preview.src = signatureData;
                    preview.style.display = 'block';
                }
            }
            window.close(); // close tab
        } else {
            alert('Parent input not found.');
        }
    }
</script>
</body>
</html>