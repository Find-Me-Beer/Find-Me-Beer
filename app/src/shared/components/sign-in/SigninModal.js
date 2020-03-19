import React, {useState} from "react";
import {Button, Col, Image, Row} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignInForm} from "./SignInForm";


export const SignInModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<Button className="btn button-signIn rounded" onClick={handleShow}>
				Sign In!
			</Button>

			<Modal show={show} onHide={handleClose}>
				<Modal.Header closeButton className="modal-bg-yellow">
					<Modal.Title>Welcome Back to FMB!</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<SignInForm/>
				</Modal.Body>
			</Modal>
		</>
	);
};
