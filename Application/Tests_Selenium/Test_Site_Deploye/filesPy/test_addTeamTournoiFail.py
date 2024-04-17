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

class TestAddTeamTournoiFail():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_addTeamTournoiFail(self):
    self.driver.get("http://4.234.188.41/Application/Controller/Accueil/HomePageController.php")
    self.driver.set_window_size(1527, 804)
    self.driver.find_element(By.ID, "navbarDropdownMenuLink").click()
    self.driver.find_element(By.ID, "navbarInscrireEquipe").click()
    self.driver.find_element(By.ID, "selectTeam").click()
    dropdown = self.driver.find_element(By.ID, "selectTeam")
    dropdown.find_element(By.XPATH, "//option[. = 'ZEHEF']").click()
    self.driver.find_element(By.ID, "submittqt").click()
    assert self.driver.find_element(By.ID, "swal2-title").text == "Erreur !"
    self.driver.find_element(By.CSS_SELECTOR, ".swal2-confirm").click()
    self.driver.close()
  
