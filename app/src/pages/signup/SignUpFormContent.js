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
	console.log(props);

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
									id="signupUsername"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Pick a User Name"
									type="text"
									value={values.signupUsername}
								/>
							</InputGroup>
							{
								errors.signupUsername && touched.signupUsername && (
									<div className="alert alert-danger">
										{errors.signupUsername}
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
									id="signupFullName"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Enter Full Name"
									type="text"
									value={values.signupFullName}
								/>
							</InputGroup>
							{
								errors.signupFullName && touched.signupFullName && (
									<div className="alert alert-danger">
										{errors.signupFullName}
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
									id="signupEmail"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Your Email"
									type="email"
									value={values.signupEmail}
								/>
							</InputGroup>
							{
								errors.signupEmail && touched.signupEmail && (
									<div className="alert alert-danger">
										{errors.signupEmail}
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
									id="signupPassword"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Password"
									type="password"
									value={values.signupPassword}
								/>
							</InputGroup>
							{
								errors.signupPassword && touched.signupPassword && (
									<div className="alert alert-danger">
										{errors.signupPassword}
									</div>
								)
							}
						</Form.Group>

						<Form.Group>
							<InputGroup>
								<InputGroup.Prepend>
									<InputGroup.Text>
										<FontAwesomeIcon icon="ellipsis-h"/>
									</InputGroup.Text>
								</InputGroup.Prepend>
								<FormControl
									id="signupPasswordConfirm"
									onChange={handleChange}
									onBlur={handleBlur}
									placeholder="Confirm Password"
									type="password"
									value={values.signupPasswordConfirm}
								/>
							</InputGroup>
							{
								errors.signupPasswordConfirm && touched.signupPasswordConfirm && (
									<div className="alert alert-danger">
										{errors.signupPasswordConfirm}
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
