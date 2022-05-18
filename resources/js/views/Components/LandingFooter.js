import React from "react"
import { makeStyles } from "@material-ui/core/styles";

import GridContainer from "components/Grid/GridContainer.js";
import GridItem from "components/Grid/GridItem.js";

import styles from "./style/mainStyle.js";

const useStyles = makeStyles(styles);

export default function LandingFooter() {

    const classes = useStyles();

    return (
        <div style={{ backgroundColor: "black" }}>
            <GridContainer justify="center">
                <GridItem xs={12} sm={6}></GridItem>
                <GridItem xs={12} sm={2}>
                    <p>Dashboard</p>
                    <p>Dashboard</p>
                    <p>Dashboard</p>
                    <p>Dashboard</p>
                </GridItem>
                <GridItem xs={12} sm={2}>
                    <p>FAQ</p>
                    <p>FAQ</p>
                    <p>FAQ</p>
                </GridItem>
                <GridItem xs={12} sm={2}>
                    <p>メールアドレス</p>
                    <p>メールアドレス</p>
                    <p>メールアドレス</p>
                </GridItem>
            </GridContainer>
        </div>
    );
}