import React from "react"

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from 'react-bootstrap/FormControl'
import Button from "react-bootstrap/Button";
import Logo from "../../img/login.jfif"
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {Link} from "react-router-dom";
import {FormDebugger} from "../../shared/FormDebugger";


export const SignUpFormContent = (props) => {

	const {
		status,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset
	} = props;
	console.log(values);

	return (
		<>
		<Container className ="sign-up">
			<Row>
				<Col md={6} >
						<img className="img-fluid img-thumbnail" src={Logo} id="logo" alt="Responsive-image"/>
				</Col>

				<Col md={6} >
					<Form onSubmit={handleSubmit}>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="user"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userUsername"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Pick a User Name"
									type="text"
									value={values.userUsername}
								/>
							</InputGroup>
							{
								errors.userUsername && touched.userUsername && (
									<div className="alert alert-danger">
										{errors.userUsername}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="beer"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userFirstName"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Enter First Name"
									type="text"
									value={values.userFirstName}
								/>
							</InputGroup>
							{
								errors.userFirstName && touched.userFirstName && (
									<div className="alert alert-danger">
										{errors.userFirstName}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="beer"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userLastName"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Enter Last Name"
									type="text"
									value={values.userLastName}
								/>
							</InputGroup>
							{
								errors.userLastName && touched.userLastName && (
									<div className="alert alert-danger">
										{errors.userLastName}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="envelope"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userEmail"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Your Email"
									type="email"
									value={values.userEmail}
								/>
							</InputGroup>
							{
								errors.userEmail && touched.userEmail && (
									<div className="alert alert-danger">
										{errors.userEmail}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="birthday-cake"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userDOB"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Date of Birth"
									type="date"
									value={values.userDOB}
								/>

							

							</InputGroup>
							{
								errors.userDOB && touched.userDOB && (
									<div className="alert alert-danger">
										{errors.userDOB}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="key"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userPassword"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Password"
									type="password"
									value={values.userPassword}
								/>
							</InputGroup>
							{
								errors.userPassword && touched.userPassword && (
									<div className="alert alert-danger">
										{errors.userPassword}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="key"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="userPasswordConfirm"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Confirm Password"
									type="password"
									value={values.userPasswordConfirm}
								/>
							</InputGroup>
							{
								errors.userPasswordConfirm && touched.userPasswordConfirm && (
									<div className="alert alert-danger">
										{errors.userPasswordConfirm}
									</div>
								)
							}
						</Form.Group>

						<Form.Group className="text-md-right">
							<Button variant="primary" type="submit" onSubmit={handleSubmit}>
								<FontAwesomeIcon icon="paw"/>&nbsp;Join Us!
							</Button>
							<div className="my-2">
								<span className="font-weight-light font-italic">Already Have an Account?&nbsp;</span>
								<Link to="/signin">Sign In</Link>
							</div>
						</Form.Group>

						{/*for testing purposes only*/}
						<FormDebugger {...props}/>

					</Form>
				</Col>
			</Row>
		</Container>
			{console.log(status)}
			{status && (<div className={status.type}>{status.message}</div>)}

			</>
		)
};
