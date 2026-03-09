import * as THREE from "three";
import { FontLoader } from "three/examples/jsm/loaders/FontLoader.js";
import { TextGeometry } from "three/examples/jsm/geometries/TextGeometry.js";

class Pslzme3DText {
	constructor(container, data) {
		this.container = container;
		this.bevelEnabled = true;
		this.targetRotation = 0;
		this.targetRotationOnPointerDown = 0;
		this.pointerX = 0;
		this.pointerXOnPointerDown = 0;
		this.windowHalfX = window.innerWidth / 2;
		this.usedText = data.dataText;
		this.sceneBackground = data.dataBackground;
		this.highlightColorOne = data.dataHighlightColorOne;
		this.highlightColorTwo = data.dataHighlightColorTwo;
		this.highlightColorThree = data.dataHighlightColorThree;
		this.fogEnabled = data.dataFogEnabled === "yes" ? true : false;
		this.fogColor = data.dataFogColor;
		this.mirrored = data.dataMirrored === "yes" ? true : false;
		this.movingLight = data.dataMovingLight === "yes" ? true : false;
		this.rotationEnabled = data.dataRotationEnabled === "yes" ? true : false;
		this.rotationDirection = data.dataRotationDirection === "right" ? -1 : 1;
		this.dataDraggable = data.dataDraggable === "yes" ? true : false;
		this.cameraPositionX = parseFloat(data.dataCameraPosX) || 0;
		this.cameraPositionY = parseFloat(data.dataCameraPosY) || 150;
		this.cameraPositionZ = parseFloat(data.dataCameraPosZ) || 700;
		this.cameraTargetX = parseFloat(data.dataCameraTargetX) || 0;
		this.cameraTargetY = parseFloat(data.dataCameraTargetY) || 115;
		this.cameraTargetZ = parseFloat(data.dataCameraTargetZ) || 0;

		this.init();
	}

	init() {
		const width = this.container.clientWidth || 300;
		const height = this.container.clientHeight || 300;

		// CAMERA
		this.camera = new THREE.PerspectiveCamera(35, width / height, 1, 1500);
		this.camera.position.set(this.cameraPositionX, this.cameraPositionY, this.cameraPositionZ);
		this.cameraTarget = new THREE.Vector3(this.cameraTargetX, this.cameraTargetY, this.cameraTargetZ);

		// SCENE
		this.scene = new THREE.Scene();
		this.scene.background = new THREE.Color(this.sceneBackground);
		if (this.fogEnabled) {
			this.scene.fog = new THREE.Fog(this.fogColor, 250, 1400);
		}

		// LIGHTS
		const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
		dirLight.position.set(0, 0, 1).normalize();
		this.scene.add(dirLight);

		const pointLight = new THREE.PointLight(this.highlightColorOne, 5.5, 0, 0);
		pointLight.position.set(0, 100, 500);
		this.scene.add(pointLight);

		const pointLight2 = new THREE.PointLight(this.highlightColorTwo, 3.5, 0, 0);
		pointLight2.position.set(-100, 100, 0);
		this.scene.add(pointLight2);

		const pointLight3 = new THREE.PointLight(this.highlightColorThree, 3.5, 0, 0);
		pointLight3.position.set(100, 100, 0);
		this.scene.add(pointLight3);

		// GROUP
		this.group = new THREE.Group();
		this.group.position.y = 100;
		this.scene.add(this.group);

		// LOAD FONT (await)
		this.loadFont(fonts.droidSans).then((font) => {
			this.createText(font, this.mirrored);
		}); // get the font passed from wp_localize_script in pslzme-public.php

		// CREATE PLANE
		const plane = new THREE.Mesh(new THREE.PlaneGeometry(10000, 10000), new THREE.MeshBasicMaterial({ color: 0xffffff, opacity: 0.8, transparent: true }));
		plane.position.y = 100;
		plane.rotation.x = -Math.PI / 2;
		this.scene.add(plane);

		// MOVING PARTICLE LIGHT
		if (this.movingLight) {
			this.particleLight = new THREE.Mesh(new THREE.SphereGeometry(2, 8, 8), new THREE.MeshBasicMaterial({ color: 0xffffff }));
			this.particleLight.position.set(0, 150, 0);
			this.particleLight.add(new THREE.PointLight(0xffffff, 100000 / 2));
			this.scene.add(this.particleLight);
		}

		// RENDERER
		this.renderer = new THREE.WebGLRenderer({ antialias: true });
		this.renderer.setPixelRatio(window.devicePixelRatio);
		this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
		this.container.appendChild(this.renderer.domElement);

		// EVENTS
		this.addEvents();
		this.animate();
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
		const geometry = new TextGeometry(this.usedText, {
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

		const timer = Date.now() * 0.00025;

		if (this.movingLight) {
			// Move particle light in a circle
			this.particleLight.position.x = 0 + Math.sin(timer * 7) * 400;
			this.particleLight.position.y = 150 + Math.cos(timer * 5) * 100;
			this.particleLight.position.z = 0 + Math.cos(timer * 3) * 200;
		}

		// Smooth rotation
		if (this.rotationEnabled) {
			this.group.rotation.y += 0.0025 * this.rotationDirection;
		}

		this.camera.lookAt(this.cameraTarget);
		this.renderer.clear();
		this.renderer.render(this.scene, this.camera);
	};

	addEvents() {
		this.container.style.touchAction = "none";
		let isDragging = false;
		let previousX = 0;

		if (this.dataDraggable) {
			this.container.addEventListener("mousedown", (event) => {
				isDragging = true;
				previousX = event.clientX;
			});

			this.container.addEventListener("mousemove", (event) => {
				if (!isDragging) return;

				const deltaX = event.clientX - previousX;
				previousX = event.clientX;

				// rotate the group directly
				this.group.rotation.y += deltaX * 0.01; // adjust 0.01 sensitivity if needed
			});

			this.container.addEventListener("mouseup", (event) => {
				isDragging = false;
			});
		}

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
	const dataText = textElement.getAttribute("data-3d-text");
	const dataBackground = textElement.getAttribute("data-background");
	const dataHighlightColorOne = textElement.getAttribute("data-highlight-color-one");
	const dataHighlightColorTwo = textElement.getAttribute("data-highlight-color-two");
	const dataHighlightColorThree = textElement.getAttribute("data-highlight-color-three");
	const dataFogEnabled = textElement.getAttribute("data-fog-enabled");
	const dataFogColor = textElement.getAttribute("data-fog-color");
	const dataMirrored = textElement.getAttribute("data-mirrored");
	const dataMovingLight = textElement.getAttribute("data-moving-light");
	const dataRotationEnabled = textElement.getAttribute("data-rotation-enabled");
	const dataRotationDirection = textElement.getAttribute("data-rotation-direction");
	const dataDraggable = textElement.getAttribute("data-draggable");
	const cameraPositionX = textElement.getAttribute("data-camera-pos-x");
	const cameraPositionY = textElement.getAttribute("data-camera-pos-y");
	const cameraPositionZ = textElement.getAttribute("data-camera-pos-z");
	const cameraTargetX = textElement.getAttribute("data-camera-target-x");
	const cameraTargetY = textElement.getAttribute("data-camera-target-y");
	const cameraTargetZ = textElement.getAttribute("data-camera-target-z");

	const data = {
		dataText,
		dataBackground,
		dataHighlightColorOne,
		dataHighlightColorTwo,
		dataHighlightColorThree,
		dataFogEnabled,
		dataFogColor,
		dataMirrored,
		dataMovingLight,
		dataRotationEnabled,
		dataRotationDirection,
		dataDraggable,
		dataCameraPosX: cameraPositionX,
		dataCameraPosY: cameraPositionY,
		dataCameraPosZ: cameraPositionZ,
		dataCameraTargetX: cameraTargetX,
		dataCameraTargetY: cameraTargetY,
		dataCameraTargetZ: cameraTargetZ,
	};
	customize3DText(textElement, data);
});

function customize3DText(textElement, data) {
	return new Pslzme3DText(textElement, data);
}
