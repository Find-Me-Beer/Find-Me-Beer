import React, {useState} from "react";
import {Button} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignInForm} from "./SignInForm";


export const SignInModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
{/*			<Button variant="primary" onClick={handleShow}>*/}
{/*				Sign In*/}
{/*			</Button>*/}

{/*			<Modal show={show} onHide={handleClose}>*/}
{/*				<Modal.Header closeButton>*/}
{/*					<Modal.Title>Sign In</Modal.Title>*/}
{/*				</Modal.Header>*/}
{/*				<Modal.Body>*/}
{/*					<SignInForm/>*/}
{/*				</Modal.Body>*/}
{/*				<Modal.Footer>*/}
{/*					<Button variant="secondary" onClick={handleClose}>*/}
{/*						Close*/}
{/*					</Button>*/}
{/*					<Button variant="primary" onClick={handleClose}>*/}
{/*						Save Changes*/}
{/*					</Button>*/}
{/*				</Modal.Footer>*/}
{/*			</Modal>*/}
{/*		</>*/}
{/*	);*/}
{/*}*/}
			<label className="py-4" id="sign-in-label" onClick={handleShow}>
				SIGN IN
			</label>

			<Modal show={show}
					 onHide={handleClose}
					 className="bg-modal"
					 centered
			>
				<Modal.Header closeButton>
					<Modal.Title>Sign In</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<SignInForm handleClose={handleClose}/>
				</Modal.Body>
			</Modal>
		</>
	);
};