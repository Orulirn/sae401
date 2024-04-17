# Generated by Selenium IDE
import pytest
import time
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class TestValiderEquipe():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_validerEquipe(self):
    self.driver.get("http://4.234.188.41/Application/Controller/Accueil/HomePageController.php")
    self.driver.set_window_size(1532, 804)
    self.driver.find_element(By.LINK_TEXT, "Valider la création d\'une équipe").click()
    self.driver.find_element(By.ID, "Valider").click()
    assert self.driver.switch_to.alert.text == "Vous avez bien validé l\'équipe"
    self.driver.close()
  
