import React from "react";
import { connect } from 'react-redux';
import { withRouter } from "react-router-dom";
import { makeStyles } from "@material-ui/core/styles";

import ChatContent from "views/Components/ChatContent.js";
import * as projectService from 'services/projectService';

import GridContainer from "components/Grid/GridContainer.js";
import GridItem from "components/Grid/GridItem.js";
import Card from "components/Card/Card.js";
import Button from "components/CustomButtons/Button.js";

import styles from "./style/mainStyle.js";

const useStyles = makeStyles(styles);

const TimelineContent = (user) => {

  const [projectstitle, setProjectsTitle] = React.useState([]);
  const [deliverydate, setDeliveryDate ] = React.useState([]);
  let path = window.location.pathname;
    let id = path.slice(21);
    projectService.getProjects().then(res => {
      let obj = res.data.projects.find(o => o.id == id);
      setProjectsTitle(obj.title);
      setDeliveryDate(obj.delivery_date);
    });
    
  React.useEffect(() => {
    
  });

  const classes = useStyles();
 
  return (
    <div>
      <Card>
          <div className={classes.timelinecontent}>
            <GridContainer justify="center">
                <GridItem xs={12} sm={7}>
                  <p>案件名</p>
                  <h4><b>{projectstitle}</b></h4>
                </GridItem>
                <GridItem xs={12} sm={3}>
                   <p>目安納品日</p>
                   <h4><b>{deliverydate}</b></h4>
                </GridItem>
                <GridItem xs={12} sm={2}>
                    {user.user.roles[0].id == 2 &&
                    <Button style={{ backgroundColor: "red" }}>
                      検収完了
                    </Button>
                    }
                    {user.user.roles[0].id == 1 &&
                    <Button style={{ backgroundColor: "red", padding: "12px 15px"}}>
                      検収リクエスト
                    </Button>
                    }
                    {user.user.roles[0].id == 3 &&
                    <Button style={{ backgroundColor: "red" }}>
                      納品申請
                    </Button>
                    }
                </GridItem>
            </GridContainer>
            <div className={classes.underline}></div>
            <GridContainer justify="center">
                {user.user.roles[0].id !== 2  &&
                <GridItem xs={12} sm={3}>
                  <b>発注請書</b>
                  <Button style={{ backgroundColor: "lightgrey", color: "black" }}>
                    ダウンロード
                  </Button>
                  <p style={{ margin: "30px 0 0 0" }}><b>請求書</b></p>
                  <Button style={{ backgroundColor: "lightgrey", color: "black" }}>
                    ダウンロード
                  </Button>
                </GridItem>
                }
                <GridItem xs={12} sm={3}>
                  <b>必要成果物</b>
                  <Button style={{ backgroundColor: "lightgrey", color: "black" }}>
                    グラウンドデータ
                  </Button>
                  <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "12px 60px" }}>
                    等高線
                  </Button>
                  <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "12px 38px" }}>
                    簡易図化 etc…
                  </Button>
                </GridItem>
                <GridItem xs={12} sm={3}>
                  <b>依頼データ</b>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                </GridItem>
                <GridItem xs={12} sm={3}>
                  <b>成果物データ</b>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                  <div className={classes.flexContent}>
                    <Button style={{ backgroundColor: "lightgrey", color: "black", padding: "10px 25px" }}>
                      ダウンロード
                    </Button>
                    <Button className={classes.roundBtn}>
                      <i className="fa fa-paperclip" aria-hidden="true"></i>
                    </Button>
                  </div>
                </GridItem>
                {user.user.roles[0].id == 3 &&
                <GridItem xs={12} sm={3}>
                  <div style={{ textAlign: "center", paddingTop: "50px" }}>
                    <Button style={{ backgroundColor: "white", color: "red" }}>
                      作業開始
                    </Button>
                  </div>
                </GridItem>
                }
            </GridContainer>  
            <div className={classes.description}>
              <p>※ ファイルは .zip や .rar などに圧縮するようにお願いします</p>
            </div>  
            <div className={classes.underline}></div>
            <GridContainer justify="center">
              <ChatContent />
            </GridContainer>
          </div>
      </Card>
    </div>
  );
}

const mapStateToProps = (state, ownProps) => ({
  user: state.auth.user,
})

const mapDispatchToProps = ({})

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(TimelineContent))