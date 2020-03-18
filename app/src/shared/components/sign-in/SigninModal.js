import React, {useState} from "react";
import {Button, Col, Image, Row} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignInForm} from "./SignInForm";
import Logo from "../../../img/fmb-navbar-logo-gray.png"


export const SignInModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<Button className="btn button-signIn rounded" onClick={handleShow}>
				Sign In!
			</Button>

			<Modal show={show} onHide={handleClose} className="modal-dark">
				<Modal.Header closeButton>
					<Modal.Title className="modal-title">FMB Sign In!</Modal.Title>
				</Modal.Header>
				<Row className="col-12">
				<Image src={Logo} className="logo-icon-gray offset-3 mt-5" />
				</Row>
				<Modal.Body>
					<SignInForm/>
				</Modal.Body>
			</Modal>
		</>
	);
};
