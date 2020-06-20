import React, {useState} from 'react';
import {Redirect} from "react-router";
import {httpConfig} from "../../misc/http-config";
import FormControl from 'react-bootstrap/FormControl'
import * as Yup from "yup";
import {Formik} from "formik";
import {useHistory} from "react-router-dom";


import {SignInFormContent} from "./SignInFormContent";

export const SignInForm = ({handleClose}) => {
	const history = useHistory();
	const signIn = {
		userEmail: "",
		userPassword: ""
	};

	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userPassword: Yup.string()
			.required("Password is required")
	});

	const submitSignIn = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/login/", values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
					resetForm();
					history.push('/beer')
					window.location.reload();
				}
				setStatus({message, type});
			});
	};

	return (
		<Formik
			initialValues={signIn}
			onSubmit={submitSignIn}
			validationSchema={validator}
		>
			{SignInFormContent}
		</Formik>
	)

};