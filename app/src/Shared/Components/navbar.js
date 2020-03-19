import React,{useState} from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import divWithClassName from "react-bootstrap/cjs/divWithClassName";
import {Link} from "react-router-dom";

import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import Button from "react-bootstrap/Button";

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Image from "react-bootstrap/Image";
import Col from "react-bootstrap/Col";
import Logo from "../../img/fmb-navbar-logo.png"
import {UseJwt} from "../misc/JwtHelpers";
import {httpConfig} from "../misc/http-config";
import {SignInModal} from "../components/sign-in/SigninModal"
// import {SignUpModal} from "../../pages/signup/SignUpModal"



import {Modal} from "react-bootstrap";
import {SignInForm} from "../components/sign-in/SignInForm"

export const NavBar = () => {

	const jwt = UseJwt();

	const [show, setShow] = useState(false);
	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	const signOut = () => {
		httpConfig.get("apis/sign-out/")
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					window.localStorage.removeItem("jwt-token");
					console.log(reply);
					setTimeout(() => {
						window.location = "/";
					});
				}
			});
	};

	return (
		<>
			<header>
				<Navbar className="navbar" variant="dark" sticky="top" collapseOnSelect expand="lg">
					<Container>
						<Row>
							<Col xs={6} md={4}>
								<Link to="/" >
									<img src={Logo} id="logo-nav" alt="logo-nav" />
								</Link>
							</Col>
						</Row>
					</Container>
					<Navbar.Toggle aria-controls="responsive-navbar-nav" />
					<Navbar.Collapse id="responsive-navbar-nav">
						<div className="navbar-collapse  flex-row" id="navbarNavAltMarkup">


							<Link className="nav-link" to="/">
								<Navbar.Brand>Home</Navbar.Brand>
							</Link>

							<Link className="nav-link" to="/beer">
								<Navbar.Brand className="fmb-link">FMB!</Navbar.Brand>
							</Link>


							{/* conditional render sign-up and sign-in only if null jwt / user is not logged in */}
							{jwt === null && (
								<>
									<Link className="nav-link" to="/signup">
										<Navbar.Brand>Sign Up!</Navbar.Brand>
									</Link>
									<Link className="nav-link">
										<Button className="btn button-signIn rounded" onClick={handleShow}>
											Sign In!
										</Button>
									</Link>
								</>
							)}

							{/* conditional render sign out only if user has jwt / is logged in */}
							{jwt !== null && (
								<Link className="nav-link">
									<Button className="btn btn-signIn" onClick={signOut}>
										Sign Out!
									</Button>
								</Link>
							)}

						</div>
					</Navbar.Collapse>
				</Navbar>

				{/* modal window for sign in */}
				<Modal show={show} onHide={handleClose} className="modal-bg-yellow">
					<Modal.Header closeButton className="modal-bg-yellow">
						<Modal.Title className="modal-bg-yellow">FMB Sign In!</Modal.Title>
					</Modal.Header>
					<Row className="col-12 modal-bg-yellow">
						<Image src={Logo} className="modal-bg-yellow logo-icon-gray offset-3 mt-5" />
					</Row>
					<Modal.Body className="modal-bg-yellow">
						<SignInForm/>
					</Modal.Body>
				</Modal>

			</header>
		</>
	)
};
