import React from 'react';
import {Link} from "react-router-dom";


import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from 'react-bootstrap/FormControl'
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";

export const SignInFormContent = (props) => {

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
		handleReset,
	} = props;

	return (
		<>
			<Card bg="transparent" className="col-4 d-inline-block d-flex mx-auto align-items-center border-0 rounded-0">
				<Card.Body>
					<Form onSubmit={handleSubmit}>
						<Form.Group>
							<Form.Label className="sr-only">Email</Form.Label>
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
									placeholder="Email"
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

						<Form.Group className="d-inline-block">
							<Form.Label className="sr-only">Password</Form.Label>
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
									type="password"
									placeholder="Password"
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
						<Form.Group className="text-md-right">
							<Button variant="primary" type="submit">
								<FontAwesomeIcon icon="sign-in-alt"/>&nbsp;Sign In
							</Button>
						</Form.Group>

						{/*for testing purposes only*/}
						{/*<FormDebugger {...props}/>*/}

					</Form>
					<div className="my-2">
						<span className="font-weight-light font-italic">Don't have an account?&nbsp;</span>
						<Link to="/signup">Sign Up</Link>
					</div>

				</Card.Body>
			</Card>

			{console.log(status)}
			{status && (<div className={status.type}>{status.message}</div>)}
		</>
	);
};