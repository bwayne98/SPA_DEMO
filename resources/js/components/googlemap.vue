<template>
<div class="">
    <div class="grid grid-cols-4 gap-2">
        <input type="text" class="bg-gray-500/10 col-span-3 px-2 py-1 outline-cyan-700/40 rounded-sm" placeholder="請輸入出發地點" v-model="start">
        <button class=" border-2 rounded-md hover:bg-gray-600 hover:text-white disabled:opacity-50" @click="roadSearch()" :disabled="loading">{{text}}</button>
    </div>
    <div v-if="errors" class="text-center self-center text-rose-800/60"> <i class='bx bx-error-circle'></i> {{errors}} </div>
    <div class="w-full h-72 py-2">
        <div id="map" class="w-full h-full border-2 rounded-md border-t-cyan-700/20 border-r-cyan-700/50 border-l-cyan-700/20 border-b-cyan-700/50 shadow-lg">

        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            directionsService: null,
            directionsRenderer: null,
            errors: null,
            map: null,
            centerMarker: null,
            info:null,
            center: {
                lat: 23.711132747426316,
                lng: 120.53890123592585
            },
            zoom: 15,
            start: '',
            end: {
                lat: 23.711132747426316,
                lng: 120.53890123592585
            },
            response: null,

            loading: false
        }
    },
    mounted() {
        this.initMap();
        this.setMarker();
    },
    computed: {
        text() {
            if (this.start.trim() == '') {
                return '重置'
            } else {
                return '導航'
            }
        }
    },
    methods: {
        initMap() {
            try {
                this.map = new google.maps.Map(document.getElementById("map"), {
                    center: this.center,
                    zoom: this.zoom,
                    fullscreenControl: false,
                    streetViewControl: false,
                    mapTypeControl: false,
                    zoomControl: false
                });
                this.directionsService = new google.maps.DirectionsService();
                this.directionsRenderer = new google.maps.DirectionsRenderer();
                this.directionsRenderer.setMap(this.map);
                // this.directionsRenderer.setPanel(document.getElementById('directionsPanel'))

            } catch (error) {
                console.log(error);
            }
        },
        setMarker() {
            this.centerMarker = new google.maps.Marker({
                position: this.center,
                map: this.map,
                animation:google.maps.Animation.DROP,
                label:{
                    text:"J",
                    color:"#ffffff",
                    fontSize:"16px"
                },
                // icon:{
                //     path:'M320 64.01v259.4c0 86.36-71.78 156.6-160 156.6s-160-70.26-160-156.6V288c0-17.67 14.31-32 32-32s32 14.33 32 32v35.38c0 51.08 43.06 92.63 96 92.63s96-41.55 96-92.63V64.01c0-17.67 14.31-32 32-32S320 46.34 320 64.01z',
                //     fillColor: '#ff0000',
                //     fillOpacity: 1,
                //     scale:0.08,
                //     strokeWeight: 2,
                //     anchor: new google.maps.Point(160, 512),
                // }
            })

            this.info = new google.maps.InfoWindow({
                content: '<div class="font-bold">佳音英語斗六分校</div>' +
                    '<div class="py-1"> 640 雲林縣斗六市武昌路39號 </div>' +
                    '<div class="pb-1"> 05-534-9906 </div>' +
                    '<div class="hover:text-cyan-700/80" ><a target="_blank" href="https://www.google.com/maps/place/%E4%BD%B3%E9%9F%B3%E8%8B%B1%E8%AA%9E%E6%96%97%E5%85%AD%E5%88%86%E6%A0%A1/@23.7109093,120.5379195,18z/data=!4m5!3m4!1s0x346ec8253a79cae9:0xf54b567ab28968a4!8m2!3d23.7110373!4d120.538899">在 Google 地圖上查看</a></div>'
            })

            this.centerMarker.addListener('click', () => {
                this.info.open({
                    anchor: this.centerMarker,
                    map: this.map,
                })
            })

            this.info.open({
                anchor: this.centerMarker,
                map: this.map,
            })

        },
        roadSearch() {
            this.loading = true
            this.errors = null
            if (this.start.trim() == '') {
                // this.directionsRenderer.setMap(null);
                // this.directionsRenderer = new google.maps.DirectionsRenderer();
                // this.directionsRenderer.setMap(this.map);

                this.directionsRenderer.setDirections({
                    geocoded_waypoints: [],
                    routes: []
                });
                this.centerMarker.setMap(this.map);
                this.map.panTo(this.centerMarker.getPosition())
                this.info.open({
                    anchor: this.centerMarker,
                    map: this.map,
                })

                this.loading = false
                return
            }

            var request = {
                origin: this.start,
                destination: this.end,
                travelMode: 'DRIVING'
            };
            this.directionsService.route(request).then(response => {
                this.directionsRenderer.setDirections(response);
                console.log(response);
                this.centerMarker.setMap(null);
            }).catch(err => {
                this.errors = '無法辨認的地點，請再確認地址';
            });

            this.loading = false
        }
    }
}
</script>
