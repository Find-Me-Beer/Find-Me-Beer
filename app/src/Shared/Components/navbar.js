import React from 'react';
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



export const NavBar = () => {
	const jwt = UseJwt();
	const signOut = () => {
		httpConfig.get("apis/sign-out/")
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					window.localStorage.removeItem("jwt-token");
					console.log(reply);
					setTimeout(() => {
						window.location = "/";
					}, 1500);
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
					<Navbar.Toggle className="float-right" aria-controls="responsive-navbar-nav" />
					<Navbar.Collapse id="responsive-navbar-nav">
						<div className="navbar-collapse row-cols-12" id="navbarNavAltMarkup">
					<Link className="nav-link" to="/">
						<Navbar.Brand>Home</Navbar.Brand>
					</Link>
					<Link className="nav-link" to="/beer">
						<Navbar.Brand className="fmb-link">FMB!</Navbar.Brand>
					</Link>
							<Link className="nav-link" to="/signup">
							<Navbar.Brand>Sign Up!</Navbar.Brand>
						</Link>
					<Link className="nav-link col-12">
						<SignInModal/>
					</Link>

							{/* conditional render if user has jwt / is logged in */}
							{jwt !== null && (
								<Button className="btn btn-signIn" onClick={signOut}>
									Sign Out!
								</Button>
							)}
						</div>
					</Navbar.Collapse>
				</Navbar>
			</header>
		</>
	)
};
