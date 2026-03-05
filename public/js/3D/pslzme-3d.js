import * as THREE from "three";
import { FontLoader } from "three/examples/jsm/loaders/FontLoader.js";
import { TextGeometry } from "three/examples/jsm/geometries/TextGeometry.js";

THREE.Cache.enabled = true;
class Pslzme3DText {
	container;
	textMesh1;
	textMesh2;
	bevelEnabled;
	font;
	targetRotation;
	targetRotationOnPointerDown;
	pointerX;
	pointerXOnPointerDown;
	windowHalfX;
	group;
	camera;
	cameraTarget;
	scene;
	renderer;
	particleLight;

	constructor(container) {
		this.container = container;
		this.bevelEnabled = true;
		this.targetRotation = 0;
		this.targetRotationOnPointerDown = 0;
		this.pointerX = 0;
		this.pointerXOnPointerDown = 0;
		this.windowHalfX = window.innerWidth / 2;

		this.init();
		this.animate();
	}

	init() {
		const width = this.container.clientWidth || 300;
		const height = this.container.clientHeight || 300;

		// CAMERA
		this.camera = new THREE.PerspectiveCamera(35, width / height, 1, 1500);
		this.camera.position.set(0, 150, 700);
		this.cameraTarget = new THREE.Vector3(0, 50, 0);

		// SCENE
		this.scene = new THREE.Scene();
		this.scene.background = new THREE.Color(0x222222);
		this.scene.fog = new THREE.Fog(0x222222, 250, 1400);

		// LIGHTS
		const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
		dirLight.position.set(0, 0, 1).normalize();
		this.scene.add(dirLight);

		const pointLight = new THREE.PointLight(0xa4dd46, 5.5, 0, 0);
		pointLight.position.set(0, 100, 500);
		this.scene.add(pointLight);

		const pointLight2 = new THREE.PointLight(0x0000ff, 3.5, 0, 0);
		pointLight2.position.set(-100, 100, 0);
		this.scene.add(pointLight2);

		const pointLight3 = new THREE.PointLight(0xff0000, 3.5, 0, 0);
		pointLight3.position.set(100, 100, 0);
		this.scene.add(pointLight3);

		// GROUP
		this.group = new THREE.Group();
		this.group.position.y = 100;
		this.scene.add(this.group);

		// LOAD FONT (await)
		this.loadFont(fonts.droidSans).then((font) => {
			this.createText(font);
		}); // get the font passed from wp_localize_script in pslzme-public.php

		// CREATE PLANE
		const plane = new THREE.Mesh(new THREE.PlaneGeometry(10000, 10000), new THREE.MeshBasicMaterial({ color: 0xffffff, opacity: 0.8, transparent: true }));
		plane.position.y = 100;
		plane.rotation.x = -Math.PI / 2;
		this.scene.add(plane);

		// MOVING PARTICLE LIGHT
		this.particleLight = new THREE.Mesh(new THREE.SphereGeometry(2, 8, 8), new THREE.MeshBasicMaterial({ color: 0xffffff }));
		this.particleLight.position.set(0, 150, 0);
		this.particleLight.add(new THREE.PointLight(0xffffff, 100000 / 2));
		this.scene.add(this.particleLight);

		// RENDERER
		this.renderer = new THREE.WebGLRenderer({ antialias: true });
		this.renderer.setPixelRatio(window.devicePixelRatio);
		this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
		this.container.appendChild(this.renderer.domElement);

		// EVENTS
		this.addEvents();
	}

	loadFont(url) {
		const loader = new FontLoader();

		return new Promise((resolve, reject) => {
			loader.load(
				url,
				(font) => resolve(font), // on load
				undefined, // on progress (not used)
				(error) => reject(error), // on error
			);
		});
	}

	createText(font, mirror = true) {
		const geometry = new TextGeometry("Max Mustermann", {
			font: font,
			size: 60,
			depth: 3,
			curveSegments: 32,
			bevelEnabled: true,
			bevelThickness: 16,
			bevelSize: 4,
			bevelOffset: 0,
			bevelSegments: 32,
		});

		geometry.computeBoundingBox();

		const centerOffset = -0.5 * (geometry.boundingBox.max.x - geometry.boundingBox.min.x);

		const materials = [
			new THREE.MeshStandardMaterial({ color: 0xffffff, flatShading: false, metalness: 0.9, roughness: 0.5 }), // front
			new THREE.MeshStandardMaterial({ color: 0xffffff, flatShading: false, metalness: 0.9, roughness: 0.5 }), // side
		];

		this.textMesh1 = new THREE.Mesh(geometry, materials);

		this.textMesh1.position.x = centerOffset;
		this.textMesh1.position.y = 20;
		this.textMesh1.position.z = 0;

		this.textMesh1.rotation.x = 0;
		this.textMesh1.rotation.y = Math.PI * 2;

		this.group.add(this.textMesh1);

		if (mirror) {
			this.textMesh2 = new THREE.Mesh(geometry, materials);

			this.textMesh2.position.x = centerOffset;
			this.textMesh2.position.y = -20;
			this.textMesh2.position.z = 0;
			this.textMesh2.rotation.x = Math.PI;
			this.textMesh2.rotation.y = Math.PI * 2;

			this.group.add(this.textMesh2);
		}
	}

	animate = () => {
		requestAnimationFrame(this.animate);

		// Automatic rotation
		this.targetRotation -= 0.002;

		const timer = Date.now() * 0.00025;

		// Move particle light in a circle
		this.particleLight.position.x = 0 + Math.sin(timer * 7) * 400;
		this.particleLight.position.y = 150 + Math.cos(timer * 5) * 100;
		this.particleLight.position.z = 0 + Math.cos(timer * 3) * 200;

		// Smooth rotation
		this.group.rotation.y += (this.targetRotation - this.group.rotation.y) * 0.05;

		this.camera.lookAt(this.cameraTarget);
		this.renderer.clear();
		this.renderer.render(this.scene, this.camera);
	};

	addEvents() {
		this.container.style.touchAction = "none";

		this.container.addEventListener("pointerdown", (event) => {
			if (!event.isPrimary) return;

			this.pointerXOnPointerDown = event.clientX - this.windowHalfX;

			this.targetRotationOnPointerDown = this.targetRotation;
		});

		this.container.addEventListener("pointermove", (event) => {
			if (!event.isPrimary) return;

			this.pointerX = event.clientX - this.windowHalfX;

			this.targetRotation = this.targetRotationOnPointerDown + (this.pointerX - this.pointerXOnPointerDown) * 0.02;
		});

		this.container.addEventListener("pointerup", (event) => {
			if (!event.isPrimary) return;
			this.container.removeEventListener("pointermove", this.onPointerMove);
			this.container.removeEventListener("pointerup", this.onPointerUp);
		});

		window.addEventListener("resize", () => this.onResize());
	}

	onResize() {
		this.windowHalfX = window.innerWidth / 2;

		this.camera.aspect = this.container.clientWidth / this.container.clientHeight;

		this.camera.updateProjectionMatrix();

		this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
	}
}

document.querySelectorAll(".pslzme-3d-text").forEach((textElement) => {
	customize3DText(textElement);
});

function customize3DText(textElement) {
	new Pslzme3DText(textElement);
}
