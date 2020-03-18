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


export const NavBar = () => {
	return (
		<>
			<header>
				<Navbar className="navbar" variant="dark" sticky="top" collapseOnSelect expand="lg">
					<Container>
						<Row>
							<Col xs={6} md={4}>
								<Link to="/">
									<img src={Logo} id="logo-nav" alt="logo-nav" />
								</Link>
							</Col>
						</Row>
					</Container>
					<Navbar.Toggle aria-controls="responsive-navbar-nav" />
					<Navbar.Collapse id="responsive-navbar-nav">
						<div className="navbar-collapse flex-row-reverse" id="navbarNavAltMarkup">
					<Link to="/">
						<Navbar.Brand>Home</Navbar.Brand>
					</Link>
					<Link to="/beer">
						<Navbar.Brand>FMB!</Navbar.Brand>
					</Link>
					<Link to="/signin">
						<Navbar.Brand>Sign In!</Navbar.Brand>
					</Link>
					<Link to="/signup">
						<Navbar.Brand>Sign Up!</Navbar.Brand>
					</Link>
						</div>
					</Navbar.Collapse>
				</Navbar>
			</header>
		</>
	)
};

