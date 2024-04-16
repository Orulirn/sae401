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

class TestModifierProfilUser():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_modifierProfilUser(self):
    self.driver.get("http://localhost/Application/Controller/Accueil/HomePageController.php")
    self.driver.set_window_size(1526, 804)
    self.driver.find_element(By.ID, "navbarDropdownTournoi").click()
    self.driver.find_element(By.ID, "navbarModifierProfil").click()
    self.driver.find_element(By.NAME, "firstname").click()
    self.driver.find_element(By.NAME, "firstname").send_keys("Corentin2")
    self.driver.find_element(By.NAME, "lastname").click()
    self.driver.find_element(By.NAME, "lastname").send_keys("Gauquier3")
    self.driver.find_element(By.ID, "modify").click()
    assert self.driver.find_element(By.ID, "swal2-title").text == "Modification"
    self.driver.find_element(By.CSS_SELECTOR, ".swal2-confirm").click()
    self.driver.close()
  