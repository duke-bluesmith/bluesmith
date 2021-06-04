<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!--Mobile meta-data -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="description" content="Bluesmith 3D Print Job Management" />
	<meta name="keywords" content="Bluesmith,3D print,job,manage" />
	<meta name="author" content="Duke University OIT" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

	<title>Bluesmith<?= empty($title) ? '' : " | {$title}" ?></title>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>assets/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= base_url() ?>assets/favicon/safari-pinned-tab.svg" color="#012169">
	<link rel="shortcut icon" href="<?= base_url() ?>assets/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="msapplication-config" content="<?= base_url() ?>assets/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
</head>
<body>
		<!-- Derive from the following examples: -->
		<!-- https://github.com/mrdoob/three.js/blob/dev/examples/webgl_loader_stl.html -->
		<!-- https://github.com/mrdoob/three.js/blob/dev/examples/webgl_animation_keyframes.html -->
		<script type="module">

			import * as THREE from 'https://cdn.skypack.dev/three@0.129.0';

			import Stats from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/libs/stats.module.js';

			import { STLLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/STLLoader.js';

			import { OrbitControls } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js';
			import { RoomEnvironment } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/environments/RoomEnvironment.js';

			let container, stats;

			let camera, cameraTarget, scene, renderer;

			init();
			animate();

			function init() {

				container = document.createElement( 'div' );
				document.body.appendChild( container );

				// renderer

				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				renderer.outputEncoding = THREE.sRGBEncoding;
				renderer.shadowMap.enabled = true;

				container.appendChild( renderer.domElement );

				const pmremGenerator = new THREE.PMREMGenerator( renderer );

				camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 100 );
				camera.position.set( 5, 2, 8 );

				cameraTarget = new THREE.Vector3( 0, - 0.25, 0 );

				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0x72645b );
				scene.environment = pmremGenerator.fromScene( new RoomEnvironment(), 0.04 ).texture;

				const controls = new OrbitControls( camera, renderer.domElement );
				controls.target.set( 0, 0.5, 0 );
				controls.update();
				controls.enablePan = false;
				controls.enableDamping = true;

				// Ground

				const plane = new THREE.Mesh(
					new THREE.PlaneGeometry( 40, 40 ),
					new THREE.MeshPhongMaterial( { color: 0x999999, specular: 0x101010 } )
				);
				plane.rotation.x = - Math.PI / 2;
				plane.position.y = - 0.5;
				scene.add( plane );

				plane.receiveShadow = true;

				// Load the file

				const loader = new STLLoader();
				const material = new THREE.MeshPhongMaterial( { color: 0x0680CD, specular: 0x111111, shininess: 200 } );

				// Colored binary STL
				loader.load( '<?= site_url('/files/export/stl/' . $id) ?>', function ( geometry ) {

					let meshMaterial = material;

					if ( geometry.hasColors ) {

						meshMaterial = new THREE.MeshPhongMaterial( { opacity: geometry.alpha, vertexColors: true } );

					}

					const mesh = new THREE.Mesh( geometry, meshMaterial );

					mesh.position.set( 0.5, 0.2, 0 );
					mesh.rotation.set( - Math.PI / 2, Math.PI / 2, 0 );
					mesh.scale.set( 0.3, 0.3, 0.3 );

					mesh.receiveShadow = true;

					scene.add( mesh );

				} );


				// Lights

				scene.add( new THREE.HemisphereLight( 0x443333, 0x111122 ) );

				addShadowedLight( 1, 1, 1, 0xffffff, 1.35 );
				addShadowedLight( 0.5, 1, - 1, 0xffaa00, 1 );

				// stats

				stats = new Stats();
				container.appendChild( stats.dom );

				//

				window.addEventListener( 'resize', onWindowResize );

			}

			function addShadowedLight( x, y, z, color, intensity ) {

				const directionalLight = new THREE.DirectionalLight( color, intensity );
				directionalLight.position.set( x, y, z );
				scene.add( directionalLight );

				directionalLight.castShadow = true;

				const d = 1;
				directionalLight.shadow.camera.left = - d;
				directionalLight.shadow.camera.right = d;
				directionalLight.shadow.camera.top = d;
				directionalLight.shadow.camera.bottom = - d;

				directionalLight.shadow.camera.near = 1;
				directionalLight.shadow.camera.far = 4;

				directionalLight.shadow.bias = - 0.002;

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function animate() {

				requestAnimationFrame( animate );

				render();
				stats.update();

			}

			function render() {

				const timer = Date.now() * 0.0005;

				camera.lookAt( cameraTarget );

				renderer.render( scene, camera );

			}

		</script>
</body>
</html>
