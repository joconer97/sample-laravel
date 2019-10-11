<template>
    <body>
        <video id="video" autoplay muted style="col-md-8" height="500" width="600"></video>
    </body>

</template>

<script>
import * as faceapi from "../../../face-api.min.js";
import {bus} from '../../main.js'
export default {
    props : ['employee'],
    mounted(){
        console.log(this.employee)
        this.initializeCamera(this.employee)
    },
    methods : {
        getEmployee(id){
            let index = this.employees.findIndex(employee => employee.id == id)

            return this.employees[index]
        },
        showInformation(name){
            this.boxTwo = ''
            this.$bvModal.msgBoxConfirm('Please confirm that you want to ' + name, {
            title: 'Please Confirm',
            size: 'sm',
            buttonSize: 'sm',
            okVariant: 'danger',
            okTitle: 'YES',
            cancelTitle: 'NO',
            footerClass: 'p-2',
            hideHeaderClose: false,
            centered: true
            })
            .then(value => {
                //value is true of false
                if(!value){
                    return
                }
                this.remove(id)
            })
            .catch(err => {
                // An error occurred
            })
        },
        initializeCamera(employee){
                    const video = document.getElementById('video')
                    Promise.all([
                        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
                        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                        faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
                        faceapi.nets.faceExpressionNet.loadFromUri('/models'),
                        faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
                    ]).then(startVideo)

                    function startVideo() {
                        var constraints = { video: true, audio: true };

                        navigator.mediaDevices.getUserMedia(constraints)
                            .then(stream => video.srcObject = stream)
                            .catch(e => console.error(e));
                        }



                        video.addEventListener('play', async () => {
                        const labeledFaceDescriptors = await loadLabeledImages()
                        const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
                        const canvas = faceapi.createCanvasFromMedia(video)
                        const displaySize = { width: video.width, height: video.height }
                        faceapi.matchDimensions(canvas, displaySize)
                        var myInterval = setInterval(async () => {
                            const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors()
                            const resizedDetections = faceapi.resizeResults(detections, displaySize)
                            const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
                            results.forEach((result, i) => {
                            const box = resizedDetections[i].detection.box
                            const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                            bus.$emit('testing',this.employee);
                            this.showInformation(result.toString())
                            clearInterval(myInterval)
                            // canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
                            // drawBox.draw(canvas)
                            })
                        }, 3000)
                        })

                            function loadLabeledImages() {
                                var labels = []
                                
                                    labels.push(employee.id + '-' + employee.firstname)
    

                                return Promise.all(
                                        labels.map(async label => {
                                        const descriptions = []
                                        for (let i = 1; i <= 4; i++) {
                                            try{
                                                const path = `images/label_images/${label}/${i}.jpg`
                                                const img = await faceapi.fetchImage(path)
                                                console.log(path)
                                                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                                                descriptions.push(detections.descriptor)
                                            }catch(err){
                                                console.log(err)
                                            }
                                
                                        }

                                        return new faceapi.LabeledFaceDescriptors(label, descriptions)
                                        })
                                    )
                                    }
        }
    }
}
</script>
<style>
    canvas {
        position: absolute;
    }
</style>