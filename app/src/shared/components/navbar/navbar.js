import React, {useEffect} from "react";
import {httpConfig} from "../../misc/http-config";
import {Link} from "react-router-dom";
import {UseJwt, UseJwtUserId, UseJwtUsername} from "../../misc/JwtHelpers";

import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import NavDropdown from "react-bootstrap/NavDropdown";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {SignUpModal} from "../../../pages/signup/SignUpModal";
import {SignInModal} from "../sign-in/SigninModal";

export const NavBar = () => {
	return (
		<>
			<header>
				<Navbar class="navbar" bg="primary" expand="md" variant="light" fixed="top" id="navbar">
					<Container>
						<Row>
							<Col xs={6} md={4}>
								<Image src="" rounded />
							</Col>
							<Col xs={6} md={4}>
								<Image src="holder.js/171x180" roundedCircle />
							</Col>
							<Col xs={6} md={4}>
								<Image src="holder.js/171x180" thumbnail />
							</Col>
						</Row>
					</Container>
					<Link to="/">
						<Navbar.Brand>Find Me Beer!</Navbar.Brand>
					</Link>
					<Link to="/beer">
						<Navbar.Brand>Beer!</Navbar.Brand>
					</Link>
					<Link to="/signup">
						<Navbar.Brand>Sign Up!</Navbar.Brand>
					</Link>
					<Link to="/signin">
						<Navbar.Brand>Sign In!</Navbar.Brand>
					</Link>
					<Navbar.Toggle aria-controls="basic-navbar-nav">Find Me Beer</Navbar.Toggle>
					<Navbar.Collapse>
						<Nav className="ml-auto">
							<NavDropdown className="nav-link" title={"Profile"}>
								<NavDropdown.Item href="/beer">
									<FontAwesomeIcon icon="Favorites"/>&nbsp; Beer
								</NavDropdown.Item>
								<NavDropdown.Item>
									{/*<FontAwesomeIcon icon="Profile"/>&nbsp; Profile*/}
									<Nav.Link href="/signup">Sign Up</Nav.Link>
									<div className="dropdown-divider"/>
								</NavDropdown.Item>
								<NavDropdown.Item>
									{/*<FontAwesomeIcon icon="Profile"/>&nbsp; Profile*/}
									<Nav.Link href="/signin">Sign In</Nav.Link>
									<div className="dropdown-divider"/>
								</NavDropdown.Item>
								<div className="dropdown-item log-out-dropdown">
									<button className="btn btn-outline-dark">
										Log Out&nbsp;<FontAwesomeIcon icon="log-out-alt"/>
									</button>
								</div>
							</NavDropdown>
						</Nav>
					</Navbar.Collapse>
				</Navbar>
			</header>
		</>
	)
};